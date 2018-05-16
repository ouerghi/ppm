<?php

namespace App\Repository;

use App\Entity\PMHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PMHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PMHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PMHistory[]    findAll()
 * @method PMHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PMHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PMHistory::class);
    }

//    /**
//     * @return PMHistory[] Returns an array of PMHistory objects
//     */
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
    public function findOneBySomeField($value): ?PMHistory
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
