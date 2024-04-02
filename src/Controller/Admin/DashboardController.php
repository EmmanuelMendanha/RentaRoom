<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Ergonomy;
use App\Entity\Software;
use App\Entity\Equipment;
use App\Repository\RoomRepository;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController

{

    private RoomRepository $roomRepository;
    private BookingRepository $bookingRepository;

    // Constructor
    public function __construct(
        RoomRepository $roomRepository,
        BookingRepository $bookingRepository
    ) {
        $this->RoomRepository = $roomRepository;
        $this->BookingRepository = $bookingRepository;
    }    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'bookings' => $this->BookingRepository->findAll(),
        ]);


        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('RentaRoom');
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

    

