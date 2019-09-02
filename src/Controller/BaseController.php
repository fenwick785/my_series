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
        $serie = $repository -> findBy([],['startDate'=>'DESC'], 3, 0);
       
        $Commentaryrepository = $this->getDoctrine()->getRepository(Commentary::class);
        $commentPopulaire = $Commentaryrepository -> findCommentaryPopulaire();
    
        return $this -> render('base/home.html.twig', [
            'serie' => $serie,
            'commentPopulaire' => $commentPopulaire
           ]);


    
}
}