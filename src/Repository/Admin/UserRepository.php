<?php

declare(strict_types=1);

namespace App\Repository\Admin;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends \Doctrine\ORM\EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('u')
            ->from('App:SiteUser', 'u')
            ->where('u.username = :username OR u.email = :email')
            ->andWhere('u.enabled = TRUE')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
