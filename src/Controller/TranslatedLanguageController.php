<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TranslatedLanguageController extends AbstractController
{
    /**
     * @Route("/translated/language", name="translated_language")
     */
    public function index()
    {
        return $this->render('translated_language/index.html.twig', [
            'controller_name' => 'TranslatedLanguageController',
        ]);
    }
}
