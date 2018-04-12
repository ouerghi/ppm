<?php

namespace App\Repository;

use App\Entity\Juridique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Juridique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Juridique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Juridique[]    findAll()
 * @method Juridique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JuridiqueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Juridique::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('j')
            ->where('j.something = :value')->setParameter('value', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
