<?php

namespace App\Repository;

use App\Entity\Overview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Overview>
 *
 * @method Overview|null find($id, $lockMode = null, $lockVersion = null)
 * @method Overview|null findOneBy(array $criteria, array $orderBy = null)
 * @method Overview[]    findAll()
 * @method Overview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OverviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Overview::class);
    }

    //    /**
    //     * @return Overview[] Returns an array of Overview objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Overview
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
