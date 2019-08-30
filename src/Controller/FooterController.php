<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/contactsupport", name="contactsupport")
     */
    
    public function contactsupport() {
        return $this->render('footer/contactsupport.html.twig', []);
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
}
