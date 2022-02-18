<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\ContenuPanier;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ContainerAxkAJ3e\getSession_FactoryService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;




class PanierController extends AbstractController
{


    #[Route('/paniers', name: 'paniers')]
    public function index(ManagerRegistry $manager): Response
    {   

        if($this->isGranted("ROLE_ADMIN")){
            $paniers = $manager->getRepository(Panier::class)->findAll();
        // $users = $manager->getRepository(User::class)->findAll();
        }else{

            
           
           
            // var_dump($id);
            $paniers = $manager->getRepository(User::class)->find($this->getUser())->getPaniers();

        }

        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
            // 'users' => $users
        ]);
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // #[Route('/paniers', name: 'panier')]
    // public function index(ManagerRegistry $manager): Response
    // {   

    //     if($this->isGranted("ROLE_ADMIN")){
    //         $paniers = $manager->getRepository(Panier::class)->findAll();
    //     // $users = $manager->getRepository(User::class)->findAll();
    //     }else{

            
           
           
    //         // var_dump($id);
    //         $paniers = $manager->getRepository(User::class)->find($this->getUser())->getPaniers();

    //     }

    //     return $this->render('panier/index.html.twig', [
    //         'paniers' => $paniers,
    //         // 'users' => $users
    //     ]);
    // }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // je recupère le panier avec son identifiant
    #[Route('/panier/{id}', name: 'panier_single', requirements:['id'=>'\d+'])]
    public function single(int $id, ManagerRegistry $manager): Response
    {
        
        $panier = $manager->getRepository(Panier::class)->find($id);
        $user = $panier->getUtilisateur();
        $contenuPaniers = $panier->getContenuPaniers();

        return $this->render('panier/single.html.twig', [
            'panier' => $panier,
            'contenuPaniers' => $contenuPaniers,
            'user' => $user
        ]);
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/panier/delete', name:'panier_delete', requirements:['id'=>'\d+'] )]
    public function delete(Panier $panier, ManagerRegistry $manager){

                $em = $manager->getManager();
                $em->remove($panier);
                $em->flush();

                $this->addFlash('info','votre panier a bien été supprimé');
                return $this->redirectToRoute('produit');

    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('user/{id}/paniers', name:'paniers_user', requirements:['id'=>'\d+'] )]
    public function userPaniers(int $id, ManagerRegistry $manager){
            
                $user = $manager->getRepository(User::class)->find($id);
                $paniers = $user->getPaniers();

                return $this->render('panier/paniers_user.html.twig', [
                    'paniers' => $paniers,
                ]);
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    #[Route("/produit/{id}/add/", name:"panier_add")]
    public function add(ManagerRegistry $manager, Request $request, Produit $produit, RequestStack $requestStack):Response
    {          
                // $session = new Session();
                // $session->start();
                // $session->set('panier', false);
                    // $session->set('panier', false);
                    // $session->get('name');
                // $requestStack->getSession();
                
                $session = $requestStack->getSession();

                if(!$session->get('panier6')){

                        $panier = new Panier;
                        $panier->setEtat(0);
                        $panier->setUtilisateur($this->getUser());
                        $panier->setDate(new \DateTime());

                        $session->set('panier6', $panier);

                        dump($session);

                    }

                    dump($request); 
                    $panier2 = $request->getSession()->get('panier6');         
                    // $panier2 = $session->get('panier5');
                    // dump($session);

                    dump($panier2); 

                    $contenuPanier = new ContenuPanier();                   
                    $contenuPanier->addProduit($produit);
                    $contenuPanier->setQuantite(4);
                    $contenuPanier->setDate(new \DateTime());

                    $contenuPanier->setPanier($panier2);

                    $panier2->addContenuPanier($contenuPanier);

                    $em = $manager->getManager();
                    $em->persist($contenuPanier);
                    $em->persist($panier2);
                    $em->flush(); 

                    die();

                    // dump($panier);
                    // dump($panier->getContenuPaniers());
                    // dump($contenuPanier);
                    
                    return $this->redirectToRoute("panier_single", ['id'=> $panier->getId()]);
            
    }

    
}
