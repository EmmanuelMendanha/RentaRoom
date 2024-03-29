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
    /*public function checkBookingConfirmation(EntityManagerInterface $em)
    {
        $bookings = $em->getRepository(Booking::class)->findAll();
    
        $currentDate = new \DateTime();
        $currentDate->add(new \DateInterval('P5D')); // Add 5 days to the current date
    
        foreach ($bookings as $booking) {
            if ($booking->getDateIn() == $currentDate) {
                $this->addFlash('notice', 'Booking for ' . $booking->getRoom()->getName() . ' on ' . $booking->getDateIn()->format('Y-m-d') . ' needs confirmation.');
            }
        }

        // $this->redirectToRoute('app_admin');
    }*/
}
