<?php

namespace Seo\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('seo');

        $rootNode
            ->children()
            ->booleanNode('robots')->defaultTrue()->end()
            ->booleanNode('meta')->defaultTrue()->end()
            ->arrayNode('redirects')
            ->addDefaultsIfNotSet()
            ->children()
            ->booleanNode('enabled')->defaultFalse()->end()
            ->booleanNode('not_found_only')->defaultTrue()->end()
            ->end()
            ->end()
            ->scalarNode('cache')->defaultNull()->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
