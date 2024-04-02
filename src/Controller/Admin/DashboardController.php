<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Ergonomy;
use App\Entity\Software;
use App\Entity\Equipment;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private BookingRepository $bookingRepository, private EntityManagerInterface $entityManager)
    {

    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $currentDate = new \DateTime();
        $allbookings = $this->bookingRepository->findAll();
    
        $urgentBookings = [];
        foreach ($allbookings as $bookings) {
            if ($bookings->getDateIn()->diff($currentDate)->days <= 5 && !$bookings->isStatus()) {
                $urgentBookings[] = $bookings;
            }
        }
    
        return $this->render('admin/dashboard.html.twig', [
            'bookings' => $allbookings,
            'urgentBookings' => $urgentBookings
        ]);
    }
    
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        
        ->setTitle('RentaRoom')
        ->renderContentMaximized();
    }
    
    #[Route('/admin/reservation/{id}/confirm', name: 'admin_booking_confirm')]
  
    public function confirmReservation(Booking $booking,int $id, EntityManagerInterface $entityManager)
    {
        $booking = $entityManager->getRepository(Booking::class)->find($id);

    if (!$booking) {
        throw $this->createNotFoundException('Pas de reservation liée à cet id '.$id);
    }

        $booking->SetStatus(True);
        $entityManager->flush();
        $this->addFlash('success', 'La réservation a bien été confirmer');
        return $this->redirectToRoute('admin');
    }


    #[Route('/admin/reservation/{id}/cancel', name: 'admin_booking_cancel')]

public function deleteReservationRequest(int $id, EntityManagerInterface $entityManager)
{
    $booking = $entityManager->getRepository(Booking::class)->find($id);

    if (!$booking) {
        throw $this->createNotFoundException('Pas de reservation liée à cet id '.$id);
    }
    $entityManager->remove($booking);
    $entityManager->flush();
    $this->addFlash('success', 'La réservation a bien été annulée');
    return $this->redirectToRoute('admin'); 
}
   
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Room', 'fas fa-door-open', Room::class);
        yield MenuItem::linkToCrud('Booking', 'fas fa-calendar-alt', Booking::class);
        yield MenuItem::linkToCrud('Ergonomy', 'fas fa-chair', Ergonomy::class);
        yield MenuItem::linkToCrud('Equipment', 'fas fa-laptop', Equipment::class);
        yield MenuItem::linkToCrud('Software', 'fas fa-code', Software::class);
        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'home');
    }
}
