<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Booking;
use App\Entity\Ergonomy;
use App\Entity\Equipment;
use App\Form\BookingType;
use App\Repository\RoomRepository;
use App\Service\RoomFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ErgonomicRepository;
use App\Repository\EquipmentRepository;

class RoomsController extends AbstractController
{
    #[Route('/rooms', name: 'rooms')]
    public function showAllRooms(RoomRepository $roomRepository): Response
    {
        $rooms = $roomRepository->findAll();

        return $this->render('rooms/rooms.html.twig', [
            'rooms' => $rooms,

            'test' => $roomRepository->findByDescription('sint'),
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
            $booking->setNumber(substr(uniqid('booking-', true), 0, 15));
            $booking->setStatus(null);
        
            $em->persist($booking);
            $em->flush();

            $this->addFlash('success', 'Booking created successfully. An confirmation email has been send. You can update or delete this booking in your profile');


            return $this->redirectToRoute('room_show', ['id' => $id]);
        }

        return $this->render('rooms/show.html.twig', [
            'room' => $room,
            'bookingForm' => $form->createView(),
        ]);
    }
    public function index(Request $request, RoomRepository $roomRepository): Response
{
    $name = $request->query->get('name');
    $capacity = $request->query->get('capacity');
    $price = $request->query->get('price');
    $ergonomics = $request->query->get('ergonomics');
    $equipment = $request->query->get('equipment');

    $rooms = $roomRepository->search($name, $capacity, $price, $ergonomics, $equipment);

    return $this->render('rooms/index.html.twig', [
        'rooms' => $rooms,
    ]);
}
public function search(Request $request, RoomFilterService $roomFilterService, ErgonomicRepository $ergonomicRepository): Response
{
    $title = $request->query->get('title');
    $capacity = $request->query->get('capacity');
    $price = $request->query->get('price');
    $ergonomics = $request->query->get('ergonomics');
    $equipment = $request->query->get('equipment');

    $rooms = $roomFilterService->filter($title, $capacity, $price, $ergonomics, $equipment);

    return $this->render('rooms/rooms.html.twig', [
        'rooms' => $rooms,
        'ergonomics' => $ergonomics,
    ]);
}

   
}
  
    


