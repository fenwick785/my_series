<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType; 

class FooterController extends AbstractController
{
        
    /**
     * @Route("/cgu", name="cgu")
     */
    
    public function cgu() {
        return $this->render('footer/cgu.html.twig', []);
    }


     /**
     * @Route("/mentionslegales", name="mentionslegales")
     */
    
    public function mentionslegales() {
        return $this->render('footer/mentionslegales.html.twig', []);
    }

     /**
     * @Route("/donneesperso", name="donneesperso")
     */
    
    public function donneesperso() {
        return $this->render('footer/donneesperso.html.twig', []);
    }
     /**
     * @Route("/apropos", name="apropos")
     */
    
    public function apropos() {
        return $this->render('footer/apropos.html.twig', []);
    }
     /**
     * @Route("/souteneznous", name="souteneznous")
     */
    
    public function souteneznous() {
        return $this->render('footer/souteneznous.html.twig', []);
    }


    /**
	*
	* 
     * @Route("/contactsupport", name="contactsupport")
     */

	public function contact(Request $request, \Swift_Mailer $mailer){
        $user=false;

        if ($this->getUser()) 
        {
            $user= true;
        }
		$form = $this -> createForm(ContactType::class, null, array('user' => $user
		));
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
      
		
		return $this->render('footer/contactsupport.html.twig',  [
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
          
			-> setTo('contact@boutique.com')
			-> setBody(
				$this -> renderView('mail/contact_mail.html.twig', [
					'data' => $data
				]), 'text/html'
                );
            
            if($this->getUser())
            {
               $mail -> setFrom($this->getUser()->getEmail());
            }
            else
            {
                $mail -> setFrom($data['email']);
            }
		;
		
		if($mailer -> send($mail)){
			return true;
		}
		else{
			return false;
		}
	}	
}
