<?php

namespace App\Repository;

use App\Entity\TranslatedLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TranslatedLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TranslatedLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TranslatedLanguage[]    findAll()
 * @method TranslatedLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslatedLanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TranslatedLanguage::class);
    }

    // /**
    //  * @return TranslatedLanguage[] Returns an array of TranslatedLanguage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TranslatedLanguage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
