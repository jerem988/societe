<?php

namespace App\Repository;

use App\Entity\SocieteListTrace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocieteListTrace|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocieteListTrace|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocieteListTrace[]    findAll()
 * @method SocieteListTrace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocieteListTraceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocieteListTrace::class);
    }

    /**
     * @return SocieteHistoryIdDate[]
     */
    public function getSocieteHistoryIdDate(int $id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT slt.id, slt.createdAt
            FROM App\Entity\SocieteListTrace slt
            WHERE slt.societe_id = :id
            ORDER BY slt.id ASC'
        )->setParameter('id', $id);

        // returns an array of Product objects
        return $query->getResult();
    }

    // /**
    //  * @return SocieteListTrace[] Returns an array of SocieteListTrace objects
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
    public function findOneBySomeField($value): ?SocieteListTrace
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
