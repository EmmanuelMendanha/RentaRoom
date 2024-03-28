<?php
// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(User $user): Response
    {
        // Récupérer les réservations de l'utilisateur
        $bookings = $user->getBookingUsers();

        // Passer les réservations à la vue pour affichage
        return $this->render('account/index.html.twig', [
            'user' => $user,
            'bookings' => $bookings,
        ]);
    }
}