<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ServiceExtension extends Extension
{
    public function getAlias()
    {
        return 'raml';
    }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \InvalidArgumentException
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $ramlNode = $configs[0]['raml'];
        $container->setParameter('raml.raml.cache_dir', $ramlNode['cache_dir'] ?? null);
        $container->setParameter('raml.raml.spec_file', $ramlNode['spec_file']);
        $container->setParameter('raml.raml.exclude_url_prefixes', $ramlNode['exclude_url_prefixes'] ?? []);
        $container->setParameter('raml.raml.include_url_prefixes', $ramlNode['include_url_prefixes'] ?? ['/']);
        $container->setParameter(
            'raml.raml.allow_directory_traversal',
            $ramlNode['allow_directory_traversal'] ?? null
        );

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
