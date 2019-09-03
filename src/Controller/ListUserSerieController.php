<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListUserSerieController extends AbstractController
{
    /**
     * @Route("/list/user/serie", name="list_user_serie")
     */
    public function index()
    {
        return $this->render('list_user_serie/profil.html.twig', [
            'controller_name' => 'ListUserSerieController',
        ]);
    }

    
}
