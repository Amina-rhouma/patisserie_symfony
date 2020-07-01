<?php

namespace App\Repository;

use App\Entity\CakeLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CakeLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method CakeLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method CakeLike[]    findAll()
 * @method CakeLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CakeLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CakeLike::class);
    }

    // /**
    //  * @return CakeLike[] Returns an array of CakeLike objects
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
    public function findOneBySomeField($value): ?CakeLike
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
