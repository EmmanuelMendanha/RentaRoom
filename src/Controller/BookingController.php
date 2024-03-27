<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/booking/{id}', name: 'booking_create')]
    public function create(RoomRepository $roomRepository, $id, EntityManagerInterface $em, FlashBagInterface $flashBag): Response
    {
        $room = $roomRepository->find($id);

        $booking = new Booking();
        $booking->getRooms($room);
        $booking->getUsers($this->getUser()); // Assuming you have a logged in user.
        $booking->setDateIn(new \DateTime()); // Set this to the desired start date.
        $booking->setDateOut(new \DateTime()); // Set this to the desired end date.

        $em->persist($booking);
        $em->flush();

        $flashBag->add('success', 'Room booked successfully!');


        return $this->redirectToRoute('app_booking');
    }
}
