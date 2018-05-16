<?php

namespace App\Repository;

use App\Entity\PM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PM|null find($id, $lockMode = null, $lockVersion = null)
 * @method PM|null findOneBy(array $criteria, array $orderBy = null)
 * @method PM[]    findAll()
 * @method PM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PMRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PM::class);
    }
    /**
     * @return PM[] Returns an array of PM objects
    */

    public function findArtisanGov()
    {
        return $this->createQueryBuilder('p')
	        ->select('count(p.id) as value')
	        ->join('p.government', 'g')
	        ->addSelect('g.name')
	        ->GroupBy('g.name' )
            ->getQuery()
            ->getArrayResult()
        ;
    }
	public function findArtisanActivity()
	{
		return $this->createQueryBuilder('p')
		            ->select('count(p.id) as value')
		            ->join('p.activity', 'a')
		            ->addSelect('a.name as activity')
		            ->GroupBy('a.name ')
		            ->getQuery()
		            ->getArrayResult()
			;
	}
	public function findArtisanTrades()
	{
		return $this->createQueryBuilder('p')
		            ->select('count(p.id) as value')
		            ->join('p.trades', 't')
		            ->addSelect('t.name as trades')
		            ->GroupBy('t.name ')
		            ->getQuery()
		            ->getArrayResult()
			;
	}

	public function findArtisanActivityTrades()
	{
		return $this->createQueryBuilder('p')
		            ->select('count(p.id) as value')
		            ->join('p.activity', 'a')
		            ->addSelect('a.name as activity')
			        ->join('p.trades', 't')
			        ->addSelect('t.name as trades')
		            ->GroupBy('a.name ')
			        ->addGroupBy('t.name')
		            ->getQuery()
		            ->getArrayResult()
			;
	}

	public function findByDate()
	{
		return $this->createQueryBuilder('p')
		            ->select('count(p.id) as value')
			        ->addSelect('p.dateCreation as creation')
			        ->groupBy('p.dateCreation')
		            ->getQuery()
		            ->getArrayResult()
			;
	}



    /*
    public function findOneBySomeField($value): ?PM
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	public function getGovernmentUser($govUser)
	{
		return $this
			->createQueryBuilder('p')
			->leftJoin('p.government','g')
			->addSelect('g')
			->where('g.id = :govUser')
			->andWhere('p.isDeleted = 0')
			->orderBy('p.id', 'DESC')
			->setParameter('govUser', $govUser)
			->getQuery()
			->getResult()
			;
	}
}
