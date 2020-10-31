<?php

namespace App\DataFixtures;

use App\Entity\Admin\User;
use App\Entity\Locale\LocaleInterface;
use App\Entity\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadSettingsDataFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $locales = [LocaleInterface::LAN_RU, LocaleInterface::LAN_EN];


        foreach($locales as $locale) {
            $settings = new Settings();

            $settings->setLocale($locale);
            $settings->setPhone('+79999999999');
            $settings->setEmail('test@test.com');
            $settings->setPrivacy('empty privacy');
            $settings->setVideo($this->getReference('video_rozetked'));
            $settings->setTranslations([
                [
                    'key' => 'homepage.slider.title',
                    'translation' => 'Slider title'
                ],
                [
                    'key' => 'homepage.slider.text',
                    'translation' => 'Slider text'
                ],
            ]);

            $manager->persist($settings);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 40;
    }
}
