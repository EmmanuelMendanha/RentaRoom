<?php

namespace App\Controller;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Définition de la classe RoomsController qui hérite de AbstractController

class RoomsController extends AbstractController
{
    #[Route('/rooms', name: 'rooms')]
    public function showAllRooms(RoomRepository $roomRepository, Request $request): Response
    {
        // Création d'un nouvel objet SearchData et d'un formulaire de recherche
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

    // Si le formulaire est soumis et valide, on recherche les chambres correspondantes,
        // sinon on récupère toutes les chambres

        $rooms = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $rooms = $roomRepository->findBySearch($searchData);
        } else {
            $rooms = $roomRepository->findAll();
        }
    // Rendu de la vue 'rooms/rooms.html.twig' avec les chambres et le formulaire en paramètres
        return $this->render('rooms/rooms.html.twig', [
            'rooms' => $rooms,
            'form' => $form->createView(),
        ]);
    }

    // Définition de la route '/rooms/{id}' qui correspond à la méthode showRoom()
    #[Route('/rooms/{id}', name: 'room_show')]
    public function showRoom(RoomRepository $roomRepository, $id, Request $request, EntityManagerInterface $em): Response
    {
        $room = $roomRepository->find($id);
        $booking = new Booking();
        $user = $this->getUser();
        $form = $this->createForm(BookingType::class, $booking);
        $form = $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on met à jour le booking, on le persiste,
        // on ajoute un message flash de succès et on redirige vers la même page
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
}

