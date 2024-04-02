<?php

// Déclaration de l'espace de noms
namespace App\Controller;

// Importation des classes nécessaires
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Définition de la classe HomeController qui hérite de AbstractController
class HomeController extends AbstractController
{
    // Définition de la route '/' qui correspond à la méthode index()
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // Rendu de la vue 'home/index.html.twig' avec le nom du contrôleur en paramètre
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}