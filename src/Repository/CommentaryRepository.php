<?php

namespace App\Repository;

use App\Entity\Commentary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Commentary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentary[]    findAll()
 * @method Commentary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentary::class);
    }


    public function findCommentaryPopulaire()
    {
        // requête qui nous retourne les 3 meilleurs séries
        return $this->createQueryBuilder('c')
            -> groupBy('c.idSerie') //on regoupe par série
            -> orderBy('SUM(c.rating)', 'DESC') //par série, on fait la somme des "likes" que l'on trie de manière décroissante
            -> setMaxResults(3) //on garde les 3 premiers résultats de  notre requête
            -> getQuery()
            -> getResult()
        ;
    }

    public function findCommentaryUnpopulaire()
    {
        // requête qui nous retourne les 3 pires séries
        return $this->createQueryBuilder('c')
        ->groupBy('c.idSerie') //on regoupe par série
        ->orderBy('SUM(c.rating)', 'ASC') //par série, on fait la somme des "likes" que l'on trie de manière croissante
        ->setMaxResults(3) //on garde les 3 premiers résultats de  notre requête
        ->getQuery()
        ->getResult()
        ;
    }

}
