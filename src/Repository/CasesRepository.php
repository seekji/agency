<?php

namespace App\Repository;

use App\Dto\Api\Cases\ListRequest;
use App\Entity\Cases;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cases|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cases|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cases[]    findAll()
 * @method Cases[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cases::class);
    }

    public function findByRequest(ListRequest $request): ?array
    {
        $query = $this->createQueryBuilder('q');

        if (isset($request->services) && count($request->services)) {
            $query
                ->leftJoin('q.services', 'services')
                ->andWhere('services IN (:services)')
                ->setParameter('services', $request->services);
        }

        if (isset($request->branches) && count($request->branches)) {
            $query
                ->leftJoin('q.branch', 'branch')
                ->andWhere('branch IN (:branches)')
                ->setParameter('branches', $request->branches);
        }

        return $query
            ->andWhere('q.locale = :locale')
            ->orderBy('q.createdAt', 'DESC')
            ->setParameter('locale', $request->locale)
            ->setFirstResult($request->offset)
            ->setMaxResults($request->limit)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Cases[] Returns an array of Cases objects
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
    public function findOneBySomeField($value): ?Cases
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
