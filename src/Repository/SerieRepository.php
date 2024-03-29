<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    // /**
    //  * @return Serie[] Returns an array of Serie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Serie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Serie[] Returns an array of Serie objects
     * Fonction pour récupérrer tous les produits en fonction d'un terme de recherche
     * 
     */
    public function findBySearch($term) { 
        $term = '%' . $term . '%' ; // on définit le term pour avoir une recherche plus globale
        $builder = $this -> createQueryBuilder('s'); 
        return $builder 
            ->orWhere('s.title LIKE :term') // on veut récupérer le terme dans le titre
            ->orWhere('s.synopsis LIKE :term') // ou récuperer le terme dans le synopsis
            ->setParameter(':term',$term) // on associe :term a $term pour éviter les injections sql et protéger la requete
            ->getQuery() // on récupère le query
            ->getResult();  // on récupère le résutat de la query
    }
}
