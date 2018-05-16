<?php

namespace App\Repository;

use App\Entity\Enqueutor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Enqueutor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enqueutor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enqueutor[]    findAll()
 * @method Enqueutor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnqueutorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Enqueutor::class);
    }

//    /**
//     * @return Enqueutor[] Returns an array of Enqueutor objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Enqueutor
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
