<?php

namespace App\Repository;

use App\Entity\Cake;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cake|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cake|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cake[]    findAll()
 * @method Cake[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cake::class);
    }

    public function findById($productId)
    {
        $criteria = ['id' => $productId];

        $products = parent::findBy($criteria);

        return $products[0];
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
