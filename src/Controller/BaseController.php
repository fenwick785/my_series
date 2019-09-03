<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Commentary;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base_home")
     */
    public function index(){

        $repository = $this->getDoctrine()->getRepository(Serie::class);
                                                        // App\Entity\Serie
        $series = $repository -> findBy([],['startDate'=>'DESC'], 3, 0); // trie par date de sortie (nouveautés)
       


        $Commentaryrepository = $this->getDoctrine()->getRepository(Commentary::class);
        

        $commentsPopulaires = $Commentaryrepository -> findCommentaryPopulaire();// trie les série dans l'ordre des like (TOP)

    


        $commentUnpopulaire = $Commentaryrepository -> findCommentaryUnpopulaire();// trie les série dans l'ordre des like (FLOP)

        // $sumPopulaire = $Commentaryrepository->sumPopularity($id);

        return $this -> render('base/home.html.twig', [
            'serie' => $series,
            'commentPopulaire' => $commentsPopulaires,
            'commentUnpopulaire' => $commentUnpopulaire,
           ]);


    
}
}