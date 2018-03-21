<?php

namespace App\Repository;

use App\Entity\Trades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trades|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trades|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trades[]    findAll()
 * @method Trades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trades::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('t')
            ->where('t.something = :value')->setParameter('value', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
