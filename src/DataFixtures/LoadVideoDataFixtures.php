<?php

namespace App\DataFixtures;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\Admin\User;
use App\Entity\Locale\LocaleInterface;
use App\Entity\Settings;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadVideoDataFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $file = new UploadedFile(__DIR__ . '/static/image.png', basename(__DIR__ . '/static/image.png'), null, null, null, true);

        $media = new Media();
        $media->setBinaryContent($file);
        $media->setContext('videos');
        $media->setProviderName('sonata.media.provider.image');

        $video = new Video();
        $video->setHref('https://www.youtube.com/watch?v=GxXqEpSpY2w');
        $video->setTitle('Rozetked');
        $video->setPicture($media);

        $manager->persist($video);
        $manager->flush();

        $this->setReference('video_rozetked', $video);
    }

    public function getOrder()
    {
        return 20;
    }
}
