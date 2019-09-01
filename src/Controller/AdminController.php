<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Serie;
use App\Entity\Season;
use App\Form\UserType;
use App\Entity\Episode;
use App\Form\SerieType;
use App\Form\SeasonType;
use App\Form\EpisodeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    // ------
    //--------- CRUD SERIE ----------
    //-----------------------------------------

    // ------------ LIST SERIE ---------------------


    /**
     * @Route("/admin/serie", name="admin_serie_list")
     * 
     * Affiche la liste des series
     */
    public function adminSerie()
    {
        //1 : Récupérer tous les serie
        $repo = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repo->findAll();


        //2 : Afficher une vue (admin/produit_list.html.twig), dans laquelle on va faire un dump() de tous les serie
        return $this->render('admin/serie_list.html.twig', [
            'serie' => $serie
        ]);
    }


    // -------------- FICHE SERIE -------------------

    /**
     * @Route("/admin/serie_sheet/{id}", name="admin_serie_sheet")
     */
    public function adminSerieSheet($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $serie = $manager->find(Serie::class, $id);



        return $this->render("admin/serie_sheet.html.twig", [
            'serie' => $serie,
        ]);
    }



    // --------------- ADD SERIE ------------------

    /**
     * @Route("/admin/add/serie", name="admin_add_serie")
     */
    public function adminAddSerie(Request $request)
    {
        try {
            $serie = new Serie;

            $form = $this->createForm(SerieType::class, $serie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($serie);
                // Enregistrer la $serie dans le système 

                // On enregistre la photo en BDD et sur le serveur. 
                // if($serie -> getFile() != NULL){
                //     $serie -> uploadFile();
                // }

                $manager->flush();
                // va enregistrer $serie en BDD

                $this->addFlash('success', 'La serie n°' . $serie->getId() . ' a bien été enregistré en BDD');

                return $this->redirectToRoute('admin_serie_list');
            }
        } catch (UniqueConstraintViolationException $e) {
            $this->addFlash('errors', 'Votre serie n\'a pas été crée, le titre utilisé existe déjà');
        }


        return $this->render('admin/add_serie.html.twig', [
            'serieForm' => $form->createView()
        ]);
    }


    // ------------- DELETE SERIE ----------------------


    /**
     * @Route("admin/delete/serie/{id}", name="admin_delete_serie")
     */
    public function adminDeleteSerie($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $serie = $manager->find(Serie::class, $id);

        $manager->remove($serie);
        $manager->flush();

        $this->addFlash('success', 'La série n°' . $id . ' a bien été supprimée !');
        return $this->redirectToRoute('admin_serie_list');
    }


    // ------------- UPDATE SERIE -----------------------


    /**
     * @Route("/admin/update/serie/{id}", name="admin_update_serie")
     *
     */
    public function adminUpdateSerie($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $serie = $manager->find(Serie::class, $id); //objet rempli

        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($serie);

            $manager->flush();

            $this->addFlash('success', 'La serie n°' . $id . ' a bien été modifiée !');
            return $this->redirectToRoute('admin_serie_list');
        }

        return $this->render('admin/update_serie.html.twig', [
            'serieForm' => $form->createView()
        ]);
    }


    //------------------- 


    //--------- SAISON -----------------


    //--------------------


    // -------------- FICHE SAISON -------------------

    /**
     * @Route("/admin/season_sheet/{id}", name="admin_season_sheet")
     */
    public function adminSeasonSheet($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $season = $manager->find(Season::class, $id);



        return $this->render("admin/season_sheet.html.twig", [
            'season' => $season,
        ]);
    }



    /// ----------- ADD SAISON ---------------------

    /**
     * @Route("/admin/add/season", name="admin_add_season")
     */
    public function adminAddSeason(Request $request)
    {

        $season = new Season;

        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($season);
            // Enregistrer la $saeson dans le système 

            // On enregistre la photo en BDD et sur le serveur. 
            // if($serie -> getFile() != NULL){
            //     $serie -> uploadFile();
            // }

            $manager->flush();
            // va enregistrer $serie en BDD

            $this->addFlash('success', 'La serie n°' . $season->getId() . ' a bien été enregistré en BDD');

            return $this->redirectToRoute('admin_add_season');
        }



        return $this->render('admin/add_season.html.twig', [
            'seasonForm' => $form->createView()
        ]);
    }

        // ------------- DELETE SAISON ----------------------


    /**
     * @Route("admin/delete/season/{id}", name="admin_delete_season")
     */
    public function adminDeleteSeason($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $season = $manager->find(Season::class, $id);

        $manager->remove($season);
        $manager->flush();

        $this->addFlash('success', 'La saison n°' . $id . ' a bien été supprimée !');
        return $this->redirectToRoute('admin_serie_list');
    }

    // ------------- UPDATE SEASON -----------------------


    /**
     * @Route("/admin/update/season/{id}", name="admin_update_season")
     *
     */
    public function adminUpdateSeason($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $season = $manager->find(Season::class, $id); //objet rempli

        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($season);

            $manager->flush();

            $this->addFlash('success', 'La serie n°' . $id . ' a bien été modifiée !');
            return $this->redirectToRoute('admin_serie_list');
        }

        return $this->render('admin/update_season.html.twig', [
            'seasonForm' => $form->createView()
        ]);
    }


        //------------------- 


    //--------- EPISODE -----------------


    //--------------------


    // -------------- FICHE EPISODE -------------------

    /**
     * @Route("/admin/episode_sheet/{id}", name="admin_episode_sheet")
     */
    public function adminEpisodeSheet($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $episode = $manager->find(Episode::class, $id);



        return $this->render("admin/episode_sheet.html.twig", [
            'episode' => $episode,
        ]);
    }


    /// ----------- ADD EPISODE ---------------------

    /**
     * @Route("/admin/add/episode", name="admin_add_episode")
     */
    public function adminAddEpisode(Request $request)
    {

        $episode = new Episode;

        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($episode);
            // Enregistrer la $saeson dans le système 

            // On enregistre la photo en BDD et sur le serveur. 
            // if($serie -> getFile() != NULL){
            //     $serie -> uploadFile();
            // }

            $manager->flush();
            // va enregistrer $serie en BDD

            $this->addFlash('success', 'L\'episode n°' . $episode->getId() . ' a bien été enregistré en BDD');

            return $this->redirectToRoute('admin_add_episode');
        }



        return $this->render('admin/add_episode.html.twig', [
            'episodeForm' => $form->createView()
        ]);
    }

            // ------------- DELETE EPIDSODE ----------------------


    /**
     * @Route("admin/delete/episode/{id}", name="admin_delete_episode")
     */
    public function adminDeleteEpisode($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $episode = $manager->find(Episode::class, $id);

        $manager->remove($episode);
        $manager->flush();

        $this->addFlash('success', 'L\'épisode n°' . $id . ' a bien été supprimée !');
        return $this->redirectToRoute('admin_serie_list');
    }

        // ------------- UPDATE EPISODE -----------------------


    /**
     * @Route("/admin/update/episode/{id}", name="admin_update_episode")
     *
     */
    public function adminUpdateEpisode($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $episode = $manager->find(Episode::class, $id); //objet rempli

        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($episode);

            $manager->flush();

            $this->addFlash('success', 'L\'episode n°' . $id . ' a bien été modifiée !');
            return $this->redirectToRoute('admin_serie_list');
        }

        return $this->render('admin/update_episode.html.twig', [
            'episodeForm' => $form->createView()
        ]);
    }





    //
    //-------- CRUD USER -----------
    //





    // -------------- LIST USER ------------------


    /**
     * @route("/admin/user", name="admin_user_list")
     */
    public function adminUser()
    {
        //1 : Récupérer tous les user
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();


        //2 : Afficher une vue (admin/user_list.html.twig), dans laquelle on va faire un dump() de tous les user
        return $this->render('admin/user_list.html.twig', [
            'user' => $user,
        ]);
    }

    // --------------- DELETE USER -----------------

    /**
     * @route("admin/user/delete{id}", name="admin_user_delete")
     */
    public function adminUserDelete($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->find(User::class, $id);

        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'Le membre n°' . $id . ' a bien été supprimé !');
        return $this->redirectToRoute('admin_user_list');
    }


    // ----------------- UPDATE USER -------------

    /**
     * @route("admin/user/update{id}", name="admin_user_update")
     */

    public function adminUserUpdate($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->find(User::class, $id); //objet rempli

        $form = $this->createForm(UserType::class, $user, [
            'admin' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);

            $manager->flush();

            $this->addFlash('success', 'Le membre n°' . $id . ' a bien été modifié !');
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user_form.html.twig', [
            'userForm' => $form->createView(),
            'action' => 'update_user',
        ]);
    }


    //------------------ FICHE USER ----------------






}
