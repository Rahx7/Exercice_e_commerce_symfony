<?php

namespace App\Repository;

use App\Entity\ContenuPanier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContenuPanier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContenuPanier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContenuPanier[]    findAll()
 * @method ContenuPanier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContenuPanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContenuPanier::class);
    }

    // /**
    //  * @return ContenuPanier[] Returns an array of ContenuPanier objects
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
    public function findOneBySomeField($value): ?ContenuPanier
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
