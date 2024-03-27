<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RoomRepository;

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
    public function showRoom(RoomRepository $roomRepository, $id): Response
    {
        $room = $roomRepository->find($id);

        return $this->render('rooms/show.html.twig', [
            'room' => $room,
        ]);
    }
}

