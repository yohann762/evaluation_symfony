<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Security\Model\Authenticator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    #[IsGranted("ROLE_ADMIN")]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('espaceAdmin');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUser = $authenticationUtils->getLastUsername();


        return $this->render('admin/index.html.twig', [
            'last_username'=> $lastUser,
            'error'=>$error
        ]);
    }
    #[Route('/logout', name: 'app_logout')]

public function logout(){
        throw new \Exception('Déconnectez-vous !');
}
}
