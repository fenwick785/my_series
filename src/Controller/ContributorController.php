<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Serie;
use App\Entity\User;
use App\Entity\Season;
use App\Form\UserType;
use App\Entity\Episode;
use App\Form\SerieType;
use App\Form\SeasonType;
use App\Form\EpisodeType;
class ContributorController extends AbstractController
{
        // ----------- LISTE SERIE -----------------

    /**
     * @Route("/contributor/serie", name="contributor_serie_list")
     * 
     * Affiche la liste des series
     */
    public function contributorSerie()
    {
        //1 : Récupérer tous les serie
        $repo = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repo->findAll();


        //2 : Afficher une vue (contributor/serie_list.html.twig), dans laquelle on va faire un dump() de tous les serie
        return $this->render('contributor/serie_list.html.twig', [
            'serie' => $serie
        ]);
    }


    // -------------- FICHE SERIE --------------------

    /**
     * @Route("/contributor/serie_sheet/{id}", name="contributor_serie_sheet")
     */
    public function contributorSerieSheet($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $serie = $manager->find(Serie::class, $id);



        return $this->render("contributor/serie_sheet.html.twig", [
            'serie' => $serie,
        ]);
    }

    // ---------------- UPDATE SERIE ------------------

    /**
     * @Route("/contributor/update/serie/{id}", name="contributor_update_serie")
     *
     */
    public function contributorUpdateSerie($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $serie = $manager->find(Serie::class, $id); //objet rempli

        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($serie);

            $manager->flush();

            $this->addFlash('success', 'La serie n°' . $id . ' a bien été modifiée !');
            return $this->redirectToRoute('contributor_serie_list');
        }

        return $this->render('contributor/update_serie.html.twig', [
            'serieForm' => $form->createView()
        ]);
    }


        //------------------- 


    //--------- SAISON -----------------


    //--------------------


    // -------------- FICHE SAISON -------------------

    /**
     * @Route("/contributor/season_sheet/{id}", name="contributor_season_sheet")
     */
    public function contributorSeasonSheet($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $season = $manager->find(Season::class, $id);



        return $this->render("contributor/season_sheet.html.twig", [
            'season' => $season,
        ]);
    }

        // ------------- UPDATE SEASON -----------------------


    /**
     * @Route("/contributor/update/season/{id}", name="contributor_update_season")
     *
     */
    public function contributorUpdateSeason($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $season = $manager->find(Season::class, $id); //objet rempli

        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($season);

            $manager->flush();

            $this->addFlash('success', 'La serie n°' . $id . ' a bien été modifiée !');
            return $this->redirectToRoute('contributor_serie_list');
        }

        return $this->render('contributor/update_season.html.twig', [
            'seasonForm' => $form->createView()
        ]);
    }


        //------------------- 


    //--------- EPISODE -----------------


    //--------------------


    // -------------- FICHE EPISODE -------------------

    /**
     * @Route("/contributor/episode_sheet/{id}", name="contributor_episode_sheet")
     */
    public function contributorEpisodeSheet($id)
    {

        $manager = $this->getDoctrine()->getManager();
        $episode = $manager->find(Episode::class, $id);



        return $this->render("contributor/episode_sheet.html.twig", [
            'episode' => $episode,
        ]);
    }



           // ------------- UPDATE EPISODE -----------------------


    /**
     * @Route("/contributor/update/episode/{id}", name="contributor_update_episode")
     *
     */
    public function contributorUpdateEpisode($id, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $episode = $manager->find(Episode::class, $id); //objet rempli

        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($episode);

            $manager->flush();

            $this->addFlash('success', 'L\'episode n°' . $id . ' a bien été modifiée !');
            return $this->redirectToRoute('contributor_serie_list');
        }

        return $this->render('contributor/update_episode.html.twig', [
            'episodeForm' => $form->createView()
        ]);
    }
}
