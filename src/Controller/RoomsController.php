<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomsController extends AbstractController
{
    #[Route('/rooms', name: 'rooms')]
    public function showAllRooms(RoomRepository $roomRepository): Response
    {
        $rooms = $roomRepository->findAll();

        return $this->render('rooms/rooms.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/rooms/{id}', name: 'room_show')]
    public function showRoom(RoomRepository $roomRepository, $id, Request $request, EntityManagerInterface $em): Response
    {
        $room = $roomRepository->find($id);
        $booking = new Booking();
        $user = $this->getUser();
        $form = $this->createForm(BookingType::class, $booking);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking = $form->getData();
            $booking->setUser($user);
            $booking->addRoom($room);
            $booking->setNumber('test');
            $booking->setStatus(null);
        
            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('room_show', ['id' => $id]);
        }

        return $this->render('rooms/show.html.twig', [
            'room' => $room,
            'bookingForm' => $form->createView(),
        ]);
    }

    #[Route('/rooms/{id}/book', name: 'room_book')]
    public function bookRoom(RoomRepository $roomRepository, $id, EntityManagerInterface $em): Response
    {
        $room = $roomRepository->find($id);

        
        $booking = new Booking();
        $booking->getRooms($room);
        $booking->getUser($this->getUser()); // Assuming you have a logged in user.
        $booking->setDateIn(new \DateTime()); // Set this to the desired start date.
        $booking->setDateOut(new \DateTime()); // Set this to the desired end date.

        $em->persist($booking);
        $em->flush();

        return $this->redirectToRoute('room_show', ['id' => $id]);

    }


}

