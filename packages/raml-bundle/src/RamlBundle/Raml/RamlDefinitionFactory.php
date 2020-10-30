<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\Raml;

use Raml\ApiDefinition;
use Raml\TypeCollection;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\FileResource;

class RamlDefinitionFactory
{
    /**
     * @var RamlFileLoader
     */
    private $loader;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var string
     */
    private $cacheDir;

    public function __construct(
        RamlFileLoader $loader,
        bool $debug,
        string $cacheDir = null
    ) {
        $this->loader = $loader;
        $this->debug = $debug;
        $this->cacheDir = $cacheDir;
    }

    public function create(string $pathToRamlSpec) : ApiDefinition
    {
        if ($this->cacheDir) {
            $cachePath = $this->cacheDir . '/' . md5($pathToRamlSpec) . '.raml.php';
            $cache = new ConfigCache($cachePath, $this->debug);

            if (!$cache->isFresh()) {
                $apiDefinition = $this->loader->load($pathToRamlSpec);
                $mainRamlFile = $this->loader->getLocator()->locate($pathToRamlSpec);
                $includedFiles = $this->loader->getParser()->getIncludedFiles();
                $fileResources = [new FileResource($mainRamlFile)];
                foreach ($includedFiles as $file) {
                    $fileResources[$file] = new FileResource($file);
                }
                $cache->write(
                    '<?php return unserialize(\'' . addcslashes(serialize($apiDefinition), '\\\'') .'"\');',
                    $fileResources
                );

                return $apiDefinition;
            }

            $cachedApiDefinition = require $cachePath;
            foreach ($cachedApiDefinition->getTypes() as $type) {
                (TypeCollection::getInstance())->add($type);
            }

            return $cachedApiDefinition;
        }

        return $this->loader->load($pathToRamlSpec);
    }
}
