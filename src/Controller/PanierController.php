<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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


    #[Route('/panier/delete', name:'panier_delete', requirements:['id'=>'\d+'] )]
    public function delete(Panier $panier, ManagerRegistry $manager){

                $em = $manager->getManager();
                $em->remove($panier);
                $em->flush();

                $this->addFlash('info','votre panier a bien été supprimé');
                return $this->redirectToRoute('produit');

    }

    #[Route('user/{id}/paniers', name:'paniers_user', requirements:['id'=>'\d+'] )]
    public function userPaniers(int $id, ManagerRegistry $manager){
            
                $user = $manager->getRepository(User::class)->find($id);
                $paniers = $user->getPaniers();

                return $this->render('panier/paniers_user.html.twig', [
                    'paniers' => $paniers,
                ]);
    }

}
