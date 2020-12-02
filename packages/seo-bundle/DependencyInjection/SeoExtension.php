<?php

namespace Seo\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Seo\SeoBundle\Entity\Rule;

class SeoExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['cache']) {
            $container->setAlias('seo.metadata_cache', 'doctrine_cache.providers.'.$config['cache']);
        }

        if ($config['meta']) {
            $metaAdminDefinition = new Definition('Seo\SeoBundle\Admin\RuleAdmin', [
                null,
                Rule::class,
                'SonataAdminBundle:CRUD',
            ]);

            $metaAdminDefinition->addTag('sonata.admin', [
                'manager_type' => 'orm',
                'group' => 'SEO',
                'label' => 'Page Rules',
            ]);

            $container->setDefinition('seo.admin.rule', $metaAdminDefinition);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
