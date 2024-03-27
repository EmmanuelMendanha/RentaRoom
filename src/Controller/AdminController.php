<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function confirmBooking(Request $request, Booking $booking): Response
    {
        $booking->setStatus(True);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json(['message' => 'Réservation confirmée avec succès'], Response::HTTP_OK);
    }
    public function cancelBooking(Request $request, Booking $booking): Response
    {
        $booking->setStatus(False);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json(['message' => 'Réservation annulée avec succès'], Response::HTTP_OK);
    }
 
}
