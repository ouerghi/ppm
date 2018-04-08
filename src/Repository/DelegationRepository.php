<?php

namespace App\Repository;

use App\Entity\Delegation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Delegation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delegation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delegation[]    findAll()
 * @method Delegation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DelegationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Delegation::class);
    }

    public function getDelegation ($gov)
    {
        return $this
            ->createQueryBuilder('d')
            ->where('d.government = :govUser')
            ->setParameter('govUser', $gov)
            ;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('d')
            ->where('d.something = :value')->setParameter('value', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
