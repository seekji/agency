<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

class Configuration implements ConfigurationInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        if (Kernel::MAJOR_VERSION === 5) {
            $treeBuilder = new TreeBuilder('raml');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('raml');
        }

        $rootNode
            ->children()
                ->arrayNode('raml')
                    ->isRequired()
                    ->children()
                        ->scalarNode('cache_dir')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('spec_file')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('exclude_url_prefixes')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('include_url_prefixes')
                            ->prototype('scalar')->end()
                        ->end()
                        ->booleanNode('allow_directory_traversal')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
