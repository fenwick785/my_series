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
        $user = $this->getUser();
        $serie = $manager->find(Serie::class, $id);


        
        $addRating = $this
            ->getDoctrine()
            ->getRepository(Commentary::class)
            ->findBy([
                'idUser' => $user,
                'idSerie' => $serie,
                'rating' => $rating
            ]);

        $updateRating = $this
            ->getDoctrine()
            ->getRepository(Commentary::class)
            ->findOneBy([
                'idUser' => $user,
                'idSerie' => $serie,
            ]);


            
        if ($addRating) {
            $this->addFlash('errors', 'Vous avez déjà noté la série <b>' . $serie->getTitle() .  ' !');
        }
        if ($updateRating) {
            
            $updateRating->setRating($rating);
            $manager->persist($updateRating);
            $manager->flush();
            $this->addFlash('success', 'Il n\'y a que les $#@%! qui ne change pas d\'avis... :)');
        } 
        else {
        $commentary = new Commentary;
        $commentary->setIdSerie($serie);
        $commentary->setIdUser($user);
        $commentary->setRating($rating);


        $user->addCommentary($commentary);
        $manager->persist($commentary);
        $manager->persist($user);
        $manager->flush();
        if($rating==1){
            $this->addFlash('success', 'Vous aimez la série '. $serie->getTitle().' !');
        }
        else{
            $this->addFlash('errors', 'Vous n\'aimez pas la série '. $serie->getTitle().' !');
        }
    }
    return $this->redirectToRoute('serie_detail', [
        'id' => $id,
    ]);
    }


}
