<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
          // Vérifie si l'utilisateur est déjà connecté
            {
                if ($security->getUser() !== null) {
                    // Redirige vers la page appropriée en fonction du rôle de l'utilisateur
                    if (in_array('ROLE_USER', $security->getUser()->getRoles(), true)) {
                    return $this->redirectToRoute('home');
                } else {
                    // Redirige vers une autre page selon le rôle, ou vers une page par défaut
                    return $this->redirectToRoute('dashboard');
                }
            }
    // Récupère l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
    // Récupère le dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
                // Cette méthode peut être vide - elle sera interceptée par la clé de déconnexion sur votre pare-feu

        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
