<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContenuPanierController extends AbstractController
{
    #[Route('/contenu/panier', name: 'contenu_panier')]
    public function index(): Response
    {
        return $this->render('contenu_panier/index.html.twig', [
            'controller_name' => 'ContenuPanierController',
        ]);
    }
}
