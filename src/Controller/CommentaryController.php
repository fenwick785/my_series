<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Commentary;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaryController extends AbstractController
{
    /**
     * @Route("/commentary/{id}/{rating}/", name="like")
     */
    public function like($rating, $id, ObjectManager $manager)
    {
        // fonction like / dislike

        $user = $this->getUser();
        // on récupere les données du User
        $serie = $manager->find(Serie::class, $id);
        // on récupere les données de la série, par rapport a son id

        $addRating = $this
        // On cherche en BDD (dans la table Commentary) si il y a une ligne où le champ :
            //id_user_id correspond a l'id du user connecté
            //id_serie_id corespond a l'id de la série avec laquelle on interagie
            //rating a la valeur que l'on souhaite attribuer (1=like ou 0=dislike)
            ->getDoctrine()
            ->getRepository(Commentary::class)
            ->findBy([
                'idUser' => $user,
                'idSerie' => $serie,
                'rating' => $rating
            ]);

        $updateRating = $this
        // On cherche en BDD (dans la table Commentary) si il y a une ligne où le champ :
            //id_user_id correspond a l'id du user connecté
            //id_serie_id corespond a l'id de la série avec laquelle on interagie
            ->getDoctrine()
            ->getRepository(Commentary::class)
            ->findOneBy([
                'idUser' => $user,
                'idSerie' => $serie,
            ]);
  
        if ($addRating) {
            // si pour un même utilisateur et une même série on essaie de réatribuer la même note alors un message d'erreur s'affichera
            $this->addFlash('errors', 'Vous avez déjà noté la série <b>' . $serie->getTitle() .  ' !');
        }
        if ($updateRating) {
            // si pour un même utilisateur et une même série on souhaite changer sont choix (like->dislike ou dislike->like)
            // alors on change la valeur dans la column "rating"
            $updateRating->setRating($rating);
            $manager->persist($updateRating);
            $manager->flush();
            // message de succès
            $this->addFlash('success', 'Il n\'y a que les $#@%! qui ne change pas d\'avis... :)');
        } 
        else {
            // sinon, on instancie l'entity Commentary et on insert les valeurs suivante en BDD
        $commentary = new Commentary;
        $commentary->setIdSerie($serie); // l'id de la série
        $commentary->setIdUser($user); // l'id du User
        $commentary->setRating($rating); // le choix "like" ou "dislike"


        $user->addCommentary($commentary);
        $manager->persist($commentary);
        $manager->persist($user);
        $manager->flush();
        if($rating==1){
            // si on "like" la série, on affiche le message suivant:
            $this->addFlash('success', 'Vous aimez la série '. $serie->getTitle().' !');
        }
        else{
            // si on "dislike" la série, on affiche le message suivant:
            $this->addFlash('errors', 'Vous n\'aimez pas la série '. $serie->getTitle().' !');
        }
    }
    return $this->redirectToRoute('serie_detail', [
        'id' => $id,
    ]);
    }





}
