<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Serie;

class SerieController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('serie/index.html.twig', []);
    }

     /**
     * @Route("/category", name="category")
     */
    public function category()
    {
        return $this->render('serie/category.html.twig', []);
    }

    /**
     * @Route("/serie/{id}", name="serie_detail")
     */
    public function detailSerie($id, Request $request) {
        
        $manager = $this-> getDoctrine() -> getManager();
        $serie = $manager-> find(Serie::class, $id);

        return $this->render('serie/detail.html.twig',[
            
            'serie' => $serie,
        ]);
    }
}
