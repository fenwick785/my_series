<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Actor;
use App\Entity\ListUserSerie;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SerieController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('serie/index.html.twig', []);
    }

    // /**
    //  * @Route("/category", name="category")
    //  */
    // public function category()
    // {
    //     return $this->render('serie/category.html.twig', []);
    // }

     /**
     * @Route("serie/", name="serie")
     */
    

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

        $listUserAAjouter = $this 
            -> getDoctrine() 
            -> getRepository(ListUserSerie::class)
            -> findBy([
                'idUser' => $user,
                'Serie' => $serie,
                'state' => $state
            ]);
        if($listUserAAjouter){
            $this -> addFlash('errors', 'Cette série <b>' . $serie -> getTitle() .  '</b> est déjà dans la liste ' . $state . ' !');
        }
        else{
            $listUserSerie = new listUserSerie;
            $listUserSerie->setSerie($serie);
            $listUserSerie->setIdUser($user);
            $listUserSerie->setState($state);
    
     
            $user->addListUserSeries($listUserSerie);
            $manager->persist($listUserSerie);
            $manager->persist($user);
            $manager->flush();    
            $this -> addFlash('success', 'La série a été ajoutée à votre list "' . $state . '" !');
        }

        return $this -> redirectToRoute('serie_detail', [
            'id' => $id,
            ]);

    }

    /**
     * @Route("serie/remove/list/{id}/{state}", name="serie_remove_list" )
     */
    public function addSerieRemoveList($state, $id, ObjectManager $manager)
    {
        $user = $this->getUser();
        $serie = $manager->find(Serie::class, $id);

        $listUserASupp = $this 
            -> getDoctrine() 
            -> getRepository(ListUserSerie::class)
            -> findOneBy([
                'idUser' => $user,
                'Serie' => $serie,
                'state' => $state
            ]);

        if($listUserASupp){
            $this -> addFlash('success', 'Cette série <b>' . $serie -> getTitle() .  '</b> a été supprimée de la liste ' . $state . ' !');
            $manager -> remove($listUserASupp);
            $manager -> flush();
        }
        
        return $this -> redirectToRoute('serie_detail', [
            'id' => $id,
            ]);

    }




    /**
     * @Route("/recherche",name="recherche")
     */
    public function recherche(Request $request) {
        $term = $request -> query -> get('s');
        $repo = $this-> getDoctrine() -> getRepository(Serie::class);
      
        $series = $repo->findBySearch($term);

        $repo2 = $this->getDoctrine() -> getRepository(Actor::class);
        $actors = $repo2 -> findBySearch($term);
        
        return $this->render('serie/index.html.twig',[
            'series' => $series,
            'actors' => $actors,
        ]);
    }


    /**
     * @route("/all", name="serie_all")
     */
    public function findAllSerie(){
    $repository = $this->getDoctrine()->getRepository(Serie::class);
    // App\Entity\Serie
    $series = $repository -> findBy([],['title'=>'ASC']); // trie par date de sortie (nouveautés)

    return $this->render('serie/all.html.twig',[
        'series'=>$series
    ]);
    }



}
