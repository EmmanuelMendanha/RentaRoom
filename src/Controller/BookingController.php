<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Booking;
use App\Form\BookingType;
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
    }*/


#[Route('/booking/{id}/edit', name: 'booking_edit')]
public function edit(Request $request, Booking $booking, EntityManagerInterface $em): Response
{
    $form = $this->createForm(BookingType::class, $booking);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('account');
        $this->addFlash('success', 'Booking updated successfully.');

    }

    return $this->render('booking/edit.html.twig', [
        'booking' => $booking,
        'form' => $form->createView(),

    ]);
}

#[Route('/booking/{id}/delete', name: 'delete')]
public function delete(Booking $booking, EntityManagerInterface $em): Response
{
    $em->remove($booking);
    $em->flush();

    return $this->redirectToRoute('account');
    $this->addFlash('success', 'Booking deleted successfully.');

}
}

    

