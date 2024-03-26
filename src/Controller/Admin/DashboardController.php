<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\Equipment;
use App\Entity\Ergonomy;
use App\Entity\Room;
use App\Entity\Software;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
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
        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', '/');
    }
}
