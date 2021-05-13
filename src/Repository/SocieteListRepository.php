<?php

namespace App\Repository;

use App\Entity\SocieteList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocieteList|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocieteList|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocieteList[]    findAll()
 * @method SocieteList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocieteListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocieteList::class);
    }

    // /**
    //  * @return SocieteList[] Returns an array of SocieteList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SocieteList
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
