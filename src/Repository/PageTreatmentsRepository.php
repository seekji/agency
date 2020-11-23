<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PageTreatments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageTreatments|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTreatments|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTreatments[]    findAll()
 * @method PageTreatments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTreatmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageTreatments::class);
    }

    // /**
    //  * @return PageTreatments[] Returns an array of PageTreatments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageTreatments
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
