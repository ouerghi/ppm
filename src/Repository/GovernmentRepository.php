<?php

namespace App\Repository;

use App\Entity\Government;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Government|null find($id, $lockMode = null, $lockVersion = null)
 * @method Government|null findOneBy(array $criteria, array $orderBy = null)
 * @method Government[]    findAll()
 * @method Government[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GovernmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Government::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('g')
            ->where('g.something = :value')->setParameter('value', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
