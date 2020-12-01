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

        if ($config['redirects']['enabled']) {
            $container->setDefinition('seo.redirect_matcher', new Definition('Seo\SeoBundle\Matcher\RedirectRuleMatcher'));

            $redirectListenerDefinition = new Definition('Seo\SeoBundle\EventListener\RedirectListener', [
                new Reference('seo.redirect_rule_repository'),
                new Reference('seo.redirect_matcher'),
                new Reference('seo.metadata_cache', ContainerInterface::NULL_ON_INVALID_REFERENCE),
            ]);

            $redirectListenerDefinition->addTag('kernel.event_listener', ['event' => 'kernel.exception', 'method' => 'onException']);

            if (!$config['redirects']['not_found_only']) {
                $redirectListenerDefinition->addTag('kernel.event_listener', [
                    'event' => 'kernel.request',
                    'method' => 'onRequest',
                    'priority' => 99,
                ]);
            }

            $container->setDefinition('seo.redirect_listener', $redirectListenerDefinition);

            $redirectAdminDefinition = new Definition('Seo\SeoBundle\Admin\RedirectRuleAdmin', [
                null,
                'Seo\\SeoBundle\\Entity\\RedirectRule',
                'SonataAdminBundle:CRUD',
            ]);

            $redirectAdminDefinition
                ->addTag('sonata.admin', ['manager_type' => 'orm', 'group' => 'SEO', 'label' => 'Redirect Rules']);

            $container->setDefinition('seo.admin.rediect_rule', $redirectAdminDefinition);
        }

        if ($config['robots']) {
            $menuListenerDefinition = new Definition('Seo\SeoBundle\EventListener\ConfigureAdminMenuListener');
            $menuListenerDefinition->addTag('kernel.event_listener', [
                'event' => 'sonata.admin.event.configure.menu.sidebar',
                'method' => 'configureMenu',
            ]);

            $container->setDefinition('seo.admin.menu_listener', $menuListenerDefinition);
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
