<?php
// src/Controller/UserController.php
namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends AbstractController
{
    #[Route('/account/{id}', name: 'account')]
    public function index($id, BookingRepository $bookingRepository): Response
    {
        $user = $this->getUser();

        // Check if a user is logged in
        if (!$user) {
            throw new AccessDeniedException('You must be logged in to access this page.');
        }

        // Check if the logged in user's id matches the id parameter
        if ($user->getId() != $id) {
            throw new AccessDeniedException('This user cannot access this page.');
        }

        $bookings = $bookingRepository->findBy(['user' => $user]);

        return $this->render('account/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }
}

