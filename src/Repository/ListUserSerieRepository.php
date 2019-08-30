<?php

namespace App\Repository;

use App\Entity\ListUserSerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ListUserSerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListUserSerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListUserSerie[]    findAll()
 * @method ListUserSerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListUserSerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListUserSerie::class);
    }

    // /**
    //  * @return ListUserSerie[] Returns an array of ListUserSerie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListUserSerie
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
