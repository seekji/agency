<?php

namespace Seo\SeoBundle\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

class ConfigureAdminMenuListener
{
    /**
     * @param ConfigureMenuEvent $event
     */
    public function configureMenu(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        if (!$seo = $menu->getChild('SEO')) {
            return;
        }

        $seo->addChild('Настройки robots', ['route' => 'seo.admin.robots.edit']);
    }
}
