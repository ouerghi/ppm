<?php

namespace App\Repository;

use App\Entity\Artisan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Artisan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artisan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artisan[]    findAll()
 * @method Artisan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Artisan::class);
    }

    public function getGovernmentUser($govUser)
    {
        return $this
            ->createQueryBuilder('a')
            ->leftJoin('a.government','g')
            ->addSelect('g')
            ->where('g.id = :govUser')
            ->andWhere('a.isDeleted = 0')
            ->orderBy('a.id', 'DESC')
            ->setParameter('govUser', $govUser)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getCin($cin)
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.cin LIKE :cin')
            ->orderBy('a.cin', 'ASC')
            ->setParameter('cin', '%' . $cin . '%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getArtisans()
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.isDeleted = 0')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
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
