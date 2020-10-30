<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\Raml;

use Raml\Parser;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Loader\FileLoader;

class RamlFileLoader extends FileLoader
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(FileLocatorInterface $locator, Parser $parser)
    {
        parent::__construct($locator);

        $this->parser = $parser;
    }

    public function load($resource, $type = null)
    {
        $path = $this->locator->locate($resource);

        return $this->parser->parse($path);
    }

    /**
     * @param mixed $resource
     * @param string|null $type
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'raml' === pathinfo($resource, PATHINFO_EXTENSION);
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }
}
