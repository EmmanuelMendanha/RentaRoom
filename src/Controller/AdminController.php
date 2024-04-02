<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function confirmBooking(Request $request, Booking $booking): Response
    {
        $booking->setStatus(True); // Met à jour le statut de la réservation à True (confirmée)

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush(); // Enregistre les modifications dans la base de données

        return $this->json(['message' => 'Réservation confirmée avec succès'], Response::HTTP_OK);
    }

    public function cancelBooking(Request $request, Booking $booking): Response
    {
        $booking->setStatus(False); // Met à jour le statut de la réservation à False (annulée)

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush(); // Enregistre les modifications dans la base de données

        return $this->json(['message' => 'Réservation annulée avec succès'], Response::HTTP_OK);
    }

    /*public function checkBookingConfirmation(EntityManagerInterface $em)
    {
        $bookings = $em->getRepository(Booking::class)->findAll(); // Récupère toutes les réservations

        $currentDate = new \DateTime();
        $currentDate->add(new \DateInterval('P5D')); // Ajoute 5 jours à la date actuelle

        foreach ($bookings as $booking) {
            if ($booking->getDateIn() == $currentDate) { // Vérifie si la date d'arrivée de la réservation correspond à la date actuelle + 5 jours
                $this->addFlash('notice', 'Booking for ' . $booking->getRoom()->getName() . ' on ' . $booking->getDateIn()->format('Y-m-d') . ' needs confirmation.'); // Ajoute un message flash pour indiquer que la réservation nécessite une confirmation
            }
        }

        // $this->redirectToRoute('app_admin'); // Redirige vers la page d'administration
    }*/
}
