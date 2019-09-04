<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Commentary;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;  

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

    
	
	/**
	*
	* @Route("/contact", name="contact")
	*
	*
	*/
	public function contact(Request $request, \Swift_Mailer $mailer){
		
		$form = $this -> createForm(ContactType::class, null, array());
		$form -> handleRequest($request);
		
		// traitement des infos du formulaire
		
		if($form -> isSubmitted() && $form -> isValid()){
			
			$data = $form -> getData();
			// permet de récupérer toutes les infos du formulaire
			// prenom = $data['prenom']
			// objet = $data['objet']
			
			if($this -> sendEmail($data, $mailer)){
				// $mailer : objet swiftmailer
				$this -> addFlash('success', 'Votre email a été envoyé et sera traité dans les meilleurs délais.');
			}
			else{
				$this -> addFlash('errors', 'Un problème a eu lieu durant l\'envoie, veuillez ré-essayer plus tard');
			}
		}
		
		// Affichage de la vue
		
		return $this -> render('base/contact.html.twig', [
			'contactForm' => $form -> createView()
		]);
	}
	
	/**
	* Permet d'envoyer des emails
	*
	*/
	public function sendEmail($data, \Swift_Mailer $mailer){
		$mail = new \Swift_Message();
		// On instancie un objet swiftmailer en précisant l'objet (sujet) du mail. 
		
		$mail 
			-> setSubject('Envoyé par boutique: ' . $data['objet'])
			-> setFrom($data['email'])
			-> setTo('contact@boutique.com')
			-> setBody(
				$this -> renderView('mail/contact_mail.html.twig', [
					'data' => $data
				]), 'text/html'
			)
		;
		
		if($mailer -> send($mail)){
			return true;
		}
		else{
			return false;
		}
	}	
}
