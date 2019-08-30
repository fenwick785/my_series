<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
   /**
     * @route("/login", name="login")
     */
    public function login(AuthenticationUtils $auth){
        $lastUsername = $auth->getLastUsername();
        //recupérer le username

        $error = $auth->getLastAuthenticationError();
        //recuperer les erreurs

        if(!empty($error)){
            $this->addFlash('errors','Problème d\'identification ! ');
        }
        
        return $this->render("security/login.html.twig", [
            'lastUsername'=>$lastUsername,
        ]);
    }

    /**
     * @route("/login_check", name="login_check")
     */
    public function login_check(){

    }

    /**
     * @route("/deconnection/", name="deconnection")
     */
    public function deconnection(){
    }
}
