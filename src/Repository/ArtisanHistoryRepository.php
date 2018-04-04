<?php

namespace App\Repository;

use App\Entity\ArtisanHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ArtisanHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtisanHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtisanHistory[]    findAll()
 * @method ArtisanHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisanHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ArtisanHistory::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.something = :value')->setParameter('value', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
