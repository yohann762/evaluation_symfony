<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\AdminType;
use App\Controller\Form;
use App\Form\AdminSupType;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManager;
use App\Form\CommentaireClientType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $repo ): Response
    {
        $liste = $repo->findAll();
        
        return $this->render('home/index.html.twig', [
            'liste_produit' => $liste,
        ]);
    }
#[Route('/produit', name:'listeProduit')]
    public function listeProduit(ProduitRepository $repo ): Response
    {
        $liste = $repo->findAll();

        return $this->render('home/liste.html.twig', [
            'listeProduit' => $liste,
        ]);
    }
    #[Route('/produit/{id}', name: 'route_produit')]
    
    public function produit(int $id,CommentaireRepository $commentaireRepository, EntityManagerInterface $entityManager, ProduitRepository $repo, Request $request): Response  // Nous Injectons dans cette fonction l'identifiant de notre produit
    {
            $produit = $repo->find($id);
        $produits = $repo->findAll();
        $arrayProduit = array($produits);
            $commentaire = new Commentaire();
            $commentaire->setProduit($produit)->getProduit()->getId();
            $liste = $commentaireRepository->findAll();
        
        
            $commentaires = $produit->getCommentaires();
        

        $form = $this->createForm(CommentaireClientType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();
            $entityManager->persist($commentaire);
            $entityManager->flush();
                    }
        return $this->render('home/produit.html.twig', [
            'produit' => $produit ,
            'liste'=>$liste,
            'produits'=>$produits,
            'arrayProduit'=>$arrayProduit,
            'commentaire'=>$commentaire,
            'commentaires'=>$commentaires,

            'form' => $form->createView()

            
        ]);}
        #[IsGranted("ROLE_ADMIN")]
      /*  @ParamConverter("produit", options={"id" = "id"})*/
    #[Route('/espaceAdmin', name: 'espaceAdmin')]
    public function espaceAdminAjout( ProduitRepository $repo, EntityManagerInterface $entityManager, Request $request): Response
    {
        $produits = $repo->findAll();

        $produit = new Produit();
        $form = $this->createForm(AdminType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $produit = $form->getData();
            $entityManager->persist($produit);
            $entityManager->flush();
                    }

                    

        return $this->render('home/espaceAdmin.html.twig', [
            'produit' => $produit ,
            'produits'=>$produits,
            'form' => $form->createView()
        ]);
    }
    #[IsGranted("ROLE_ADMIN")]

    #[Route('/espaceAdminSupp/{id}', name: 'espaceAdminSupp')]

    public function espaceAdminASup(Produit $produit,ProduitRepository $repo, EntityManagerInterface $entityManager): Response
    {
        
        $produits = $repo->findAll();
        $produits = $produit->getId();
        
            $entityManager->remove($produit);
            $entityManager->flush();

     
      

            $this->addFlash('message', 'Produit supprimé avec succès');
            return $this->redirectToRoute('espaceAdmin');
                    ;
    }
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/modifier', name: 'modifier')]
    public function espaceAdmin2( CommentaireRepository $commentaireRepository, ProduitRepository $repo, EntityManagerInterface $entityManager, Request $request): Response
    {
        
        $commentaire = new Commentaire();
        $commentaires = $commentaireRepository->findAll();

        $form = $this->createForm(CommentaireClientType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();
            $entityManager->persist($commentaire);
            $entityManager->flush();
                    }

                    

        return $this->render('home/modifier.html.twig', [
            'commentaire'=>$commentaire,
            'commentaires'=>$commentaires,

            'form' => $form->createView()
        ]);
    }
   
}

   /* public function formulaire(EntityManagerInterface $entityManager, Request $request, $form): Response{
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireClientType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($commentaire);
            $entityManager->flush();
                    }
        return $this->render('home/produit.html.twig', [
            'form' => $form->createView()
        ]);
        
    }*/


