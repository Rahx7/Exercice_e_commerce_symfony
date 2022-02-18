<?php

namespace App\Controller;

use App\Entity\ContenuPanier;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContenuPanierController extends AbstractController
{
    #[Route('/contenuPanier/{id}', name: 'contenu_panier')]
    public function index(int $id, ManagerRegistry $manager  ): Response
    {
        $contenuPanier = $manager->getRepository(ContenuPanier::class)->find($id);

        return $this->render('contenu_panier/index.html.twig', [
            'contenuPanier' => $contenuPanier,
        ]);
    }
}
