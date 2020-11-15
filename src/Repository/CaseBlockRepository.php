<?php

namespace App\Repository;

use App\Entity\CaseBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CaseBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaseBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaseBlock[]    findAll()
 * @method CaseBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaseBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaseBlock::class);
    }

    // /**
    //  * @return CaseBlock[] Returns an array of CaseBlock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CaseBlock
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
