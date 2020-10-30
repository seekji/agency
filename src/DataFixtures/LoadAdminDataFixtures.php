<?php

namespace App\DataFixtures;

use App\Entity\Admin\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadAdminDataFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(static::getFakeAdmin());

        $manager->flush();
    }

    public static function getFakeAdmin(): User
    {
        $admin = new User();

        $admin
            // 123admin456
            ->setPassword('$2y$13$GAE97idHgA0vNNeZo0vbVOMo2rLHVCW0NzhPpM1c4huQZLhoS0Q/q')
            ->setUsername('admin')
            ->setEnabled(true)
            ->setEmail('admin@admin.ru')
            ->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);

        return $admin;
    }

    public function getOrder()
    {
        return 0;
    }
}
