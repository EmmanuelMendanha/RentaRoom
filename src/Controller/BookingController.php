<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    /*#[Route('/booking/{id}', name: 'booking_create', methods: ['POST', 'GET'])]
    public function create(RoomRepository $roomRepository, $id, EntityManagerInterface $em, FlashBagInterface $flashBag, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $room = $roomRepository->find($id);
    
     
        $previous = $request->headers->get('referer');
        $user = $this->getUser();
        
        $newBooking = new Booking();
        $newBooking->setNumber(uniqid())
                ->setUser($user)
                ->setRoom($room)
                ->setDateIn(new \DateTime($request->request->get('date-in')))
                ->setDateOut(new \DateTime($request->request->get('date-out')))
                ->setCreatedAt(new \DateTime('now'))
                ;

        //$user->getBookingUsers()       
        $user->addBooking($newBooking);
        

        $em->persist($newBooking);
        $em->flush();

        $flashBag->add('success', 'Room booked successfully!');


        return $this->redirectToRoute('app_booking');
    }

    /*#[Route('/booking/{id}/edit', name: 'booking_edit')]
    public function edit(BookingRepository $bookingRepository, $id, EntityManagerInterface $em): Response
    {
    }

    #[Route('/booking/{id}/delete', name: 'booking_delete')]
    public function delete(BookingRepository $bookingRepository, $id, EntityManagerInterface $em): Response
    {
    }*/
}
