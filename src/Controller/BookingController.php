<?php

namespace App\Controller;

// Importation des classes nécessaires
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

// Définition de la classe BookingController qui hérite de AbstractController
class BookingController extends AbstractController
{
    // Définition de la route '/booking' qui correspond à la méthode index()
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        // Rendu de la vue 'booking/index.html.twig' avec le nom du contrôleur en paramètre
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    // Définition de la route '/booking/{id}/edit' qui correspond à la méthode edit()
    #[Route('/booking/{id}/edit', name: 'booking_edit')]
    public function edit(Request $request, Booking $booking, EntityManagerInterface $em): Response
    {
        // Création du formulaire de type BookingType
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on enregistre les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            // Redirection vers la page 'account' et ajout d'un message flash
            $this->addFlash('success', 'Booking updated successfully.');
            return $this->redirectToRoute('account');
        }

        // Rendu de la vue 'booking/edit.html.twig' avec le booking et le formulaire en paramètres
        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    // Définition de la route '/booking/{id}/delete' qui correspond à la méthode delete()
    #[Route('/booking/{id}/delete', name: 'delete')]
    public function delete(Booking $booking, EntityManagerInterface $em): Response
    {
        // Suppression du booking et enregistrement des modifications
        $em->remove($booking);
        $em->flush();

        // Redirection vers la page 'account' et ajout d'un message flash
        $this->addFlash('success', 'Booking deleted successfully.');
        return $this->redirectToRoute('account');
    }
}