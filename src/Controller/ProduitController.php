<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'produit')]
    public function index(ManagerRegistry $manager): Response
    {
        return $this->render('produit/index.html.twig', [
            'produitList' => $manager->getRepository(Produit::class)->findAll(),
        ]);
    }
    #[
        Route('/produit/{id}', name:"produit_single",requirements:['id'=>'\d+'])
    ]
    public function single(int $id, ManagerRegistry $manager):Response
    {
        $produit = $manager->getRepository(Produit::class)->find($id);

        return $this->render("produit/single.html.twig", [
            'produit' => $produit
        ]);
    }
    #[
        Route("/produit/add", name:"produit_add"),

     ]
    public function add(ManagerRegistry $manager, Request $request):Response
    {
        $produit = new Produit;
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $manager->getManager();
                $image = $produit->getPhoto();
                $imageName = md5(uniqid()).'.'.$image->guessExtension();
            try {
                $image->move(
                    $this->getParameter('upload_files'),
                    $imageName
                );
            } catch (FileException $e) {
                $this->addFlash('danger', "une erreur s'est produite, réessayer!");
                $this->addFlash('danger', $e->getMessage());
                }
                $produit->setPhoto($imageName);
                
                $em = $manager->getManager();
                $em->persist($produit);
                $em->flush();
            } catch (\Exception $e) {
                $this->addFlash('danger', "une erreur s'est produite, réessayer!");
                $this->addFlash('danger', $e->getMessage());
            }
           
            return $this->redirectToRoute("produit");
            throw new \Exception("Générer la redirection vers la création des produits");
            
        }

        return $this->render("produit/add.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
