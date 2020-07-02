<?php

namespace App\Repository;

use App\Entity\VerrineLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VerrineLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method VerrineLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method VerrineLike[]    findAll()
 * @method VerrineLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerrineLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VerrineLike::class);
    }

    // /**
    //  * @return VerrineLike[] Returns an array of VerrineLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VerrineLike
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
