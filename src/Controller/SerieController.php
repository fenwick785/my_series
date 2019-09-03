<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Serie;
use App\Entity\ListUserSerie;

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
    public function detailSerie($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $serie = $manager->find(Serie::class, $id);

        return $this->render('serie/detail.html.twig', [

            'serie' => $serie,
        ]);
    }
    /**
     * @Route("serie/add/list/{id}/{state}", name="serie_add_list" )
     */
    public function addSerieInList($state, $id, ObjectManager $manager)
    {
        $user = $this->getUser();
        $serie = $manager->find(Serie::class, $id);
        $listUserSerie = new listUserSerie;
        $listUserSerie->setSerie($serie);
        $listUserSerie->setIdUser($user);
        $listUserSerie->setState($state);
        // $listUserSerie -> setEpisode(NULL);
        $user->addListUserSeries($listUserSerie);
        $manager->persist($listUserSerie);
        $manager->persist($user);
        $manager->flush();

        $this -> addFlash('success', 'La série a été ajoutée à votre list "' . $state . '" !');
        return $this -> redirectToRoute('serie_detail', ['id' => $id]);
    }
}
