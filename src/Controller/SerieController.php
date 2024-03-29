<?php

namespace App\Controller;

use App\Entity\Actor;
Use App\Entity\Commentary;
use App\Entity\Serie;
use App\Form\CommentaryType;
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
        //route permettant d'afficher la fiche technique d'une série par rapport a son id
        $manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $serie = $manager->find(Serie::class, $id);


        $CommentaireExistant = $this
            ->getDoctrine()
            ->getRepository(Commentary::class)
            ->findOneBy([
                'idUser' => $user,
                'idSerie' => $serie,
        ]);
    
        if($CommentaireExistant){
            $commentaire = $CommentaireExistant;
            $rating = $commentaire -> getRating();
        }
        else{
            $commentaire = new Commentary;
            $rating = NULL;
        }
                
        $form = $this->createForm(CommentaryType::class, $commentaire);        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $commentaire->setIdUser($user);
            $commentaire->setIdSerie($serie);
            $commentaire->setRating($rating);
            $manager->persist($commentaire);
            $manager->flush();
            return $this->redirectToRoute('serie_detail', array('id' => $id));
        }

        return $this->render('serie/detail.html.twig', [
            'serie' => $serie,
            'commentaryForm' => $form->createView()
        ]);
    }


    /**
     * @Route("serie/add/list/{id}/{state}", name="serie_add_list" )
     */
    public function addSerieInList($state, $id, ObjectManager $manager)
    {
        //fonction permettant d'ajouter une série a sa wishList, inProgressList ou finishList


        $user = $this->getUser();
        // on recupère les informations du User

        $serie = $manager->find(Serie::class, $id);
        // on récupère les informations d'une série précise via son id


        $listUserAAjouter = $this
        // On cherche en BDD si il y a une ligne où les champs :
            //id_user_id correspond a l'id du user connecté
            //serie_id corespond a l'id de la série avec laquelle on interagie
            //state correspond a l'état que l'on souhaite attribuer a notre série
            ->getDoctrine()
            ->getRepository(ListUserSerie::class)
            ->findBy([
                'idUser' => $user,
                'Serie' => $serie,
                'state' => $state
            ]);

        $listUserAModifier = $this
        // On cherche en BDD si il y a une ligne où les champs :
            //id_user_id correspond a l'id du user connecté
            //serie_id corespond a l'id de la série avec laquelle on interagie
            ->getDoctrine()
            ->getRepository(ListUserSerie::class)
            ->findOneBy([
                'idUser' => $user,
                'Serie' => $serie,

            ]);

        if ($listUserAAjouter) {
            // on affiche un message d'erreur comme quoi notre nous avons déja cette serie dans notre liste
            $this->addFlash('errors', 'Cette série <b>' . $serie->getTitle() .  '</b> est déjà dans la liste ' . $state . ' !');
        }
        if ($listUserAModifier) {
            // on remplace l'état dans le champ state
            $listUserAModifier->setState($state);
            $manager->persist($listUserAModifier);
            $manager->flush();
            $this->addFlash('success', 'Cette série <b>' . $serie->getTitle() .  '</b> est passée dans la liste ' . $state . ' !');
        } else {
            // on instancie l'entity ListUserSerie
            $listUserSerie = new listUserSerie;
            // on lui attribue :

            $listUserSerie->setSerie($serie); // l'id de la série
            $listUserSerie->setIdUser($user); // l'id du user
            $listUserSerie->setState($state); // l'état souhaité


            $user->addListUserSeries($listUserSerie);
            $manager->persist($listUserSerie);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'La série a été ajoutée à votre list "' . $state . '" !');
        }

        return $this->redirectToRoute('serie_detail', [
            'id' => $id,
        ]);
    }

    /**
     * @Route("serie/remove/list/{id}/{state}", name="serie_remove_list" )
     */
    public function addSerieRemoveList($state, $id, ObjectManager $manager)
    {
        // fonction permettant de supprimer une série de sa liste 
        $user = $this->getUser();
        $serie = $manager->find(Serie::class, $id);

        $listUserASupp = $this
        // On cherche en BDD si il y a une ligne où les champs :
            //id_user_id correspond a l'id du user connecté
            //serie_id corespond a l'id de la série avec laquelle on interagie
            //state correspond a l'état que l'on souhaite attribuer a notre série
            ->getDoctrine()
            ->getRepository(ListUserSerie::class)
            ->findOneBy([
                'idUser' => $user,
                'Serie' => $serie,
                'state' => $state
            ]);

        if ($listUserASupp) {
            $this->addFlash('success', 'Cette série <b>' . $serie->getTitle() .  '</b> a été supprimée de la liste ' . $state . ' !');
            $manager->remove($listUserASupp);
            $manager->flush();
        }

        return $this->redirectToRoute('serie_detail', [
            'id' => $id,
        ]);
    }




    /**
     * @Route("/recherche",name="recherche")
     */
    public function recherche(Request $request)
    {
        $term = $request->query->get('s'); // on récupère la query dans le form avec un name="s"
        $repo = $this->getDoctrine()->getRepository(Serie::class); // notre recherche sera dans la classe série

        $series = $repo->findBySearch($term); // on utilise la fonction précédemment crée pour trouver la série grâce au $term

        $repo2 = $this->getDoctrine()->getRepository(Actor::class); // ou dans la classe acteur
        $actors = $repo2->findBySearch($term); // et on utiliser la fonction précédemment crée pour trouver les acteurs par $term.

        return $this->render('serie/index.html.twig', [
            'series' => $series,
            'actors' => $actors,
        ]);
    }


    /**
     * @route("/all", name="serie_all")
     */
    public function findAllSerie()
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class); // on récupère dans notre repo un objet serie
        // App\Entity\Serie
        $series = $repository->findBy([], ['title' => 'ASC']); // on cherche toutes les séries et on les trie par date de sortie (nouveautés)

        return $this->render('serie/all.html.twig', [
            'series' => $series
        ]);
    }
}
