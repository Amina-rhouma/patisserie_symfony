<?php

namespace App\Repository;

use App\Entity\Verrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Verrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Verrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Verrine[]    findAll()
 * @method Verrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Verrine::class);
    }

    public function findById($productId)
    {
        $criteria = ['id' => $productId];

        $products = parent::findBy($criteria);

        return $products[0];
    }

    // /**
    //  * @return Verrine[] Returns an array of Verrine objects
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
    public function findOneBySomeField($value): ?Verrine
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
