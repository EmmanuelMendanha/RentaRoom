<?php

namespace App\Controller;
use App\Entity\Room;
use App\Form\SearchType;
use App\Model\SearchData;
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
use Symfony\Bundle\SecurityBundle\Security;

// Définition de la classe RoomsController qui hérite de AbstractController

class RoomsController extends AbstractController
{
    #[Route('/rooms', name: 'rooms')]
<<<<<<< HEAD
    public function showAllRooms(RoomRepository $roomRepository, Request $request): Response    // Définition de la méthode showAllRooms() qui prend en paramètres un objet RoomRepository et un objet Request
=======
    public function showAllRooms(RoomRepository $roomRepository, Request $request, Security $security): Response
>>>>>>> 05ee255624528b46abaf29eebfeb7fbadca7ade5
    {
        if (!$security->getUser()) {
            // Rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }else{
        // Création d'un nouvel objet SearchData et d'un formulaire de recherche
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

<<<<<<< HEAD
    // Si le formulaire est soumis et valide, on recherche les salles correspondantes,
        // sinon on récupère toutes les salles
!
=======
        // Si le formulaire est soumis et valide, on recherche les chambres correspondantes,
        // sinon on récupère toutes les chambres

>>>>>>> 05ee255624528b46abaf29eebfeb7fbadca7ade5
        $rooms = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $rooms = $roomRepository->findBySearch($searchData);
        } else {
            $rooms = $roomRepository->findAll();
        }
<<<<<<< HEAD
    // Rendu de la vue 'rooms/rooms.html.twig' avec les salles et le formulaire en paramètres
=======
        // Rendu de la vue 'rooms/rooms.html.twig' avec les chambres et le formulaire en paramètres
>>>>>>> 05ee255624528b46abaf29eebfeb7fbadca7ade5
        return $this->render('rooms/rooms.html.twig', [
            'rooms' => $rooms,


            'test' => $roomRepository->findByDescription('sint'),
            'form' => $form->createView(),

        ]);}
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
            $dateIn = $booking->getDateIn();
            $dateOut = $booking->getDateOut();
            if ($dateIn > $dateOut) {
                $this->addFlash('error', 'La date de début doit être antérieure ou égale à la date de fin.');
                return $this->redirect($request->headers->get('referer'));
            }
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
    $software = $request->query->get('software');

    $rooms = $roomRepository->search($name, $capacity, $price, $ergonomics, $equipment, $software);

    return $this->render('rooms/index.html.twig', [
        'rooms' => $rooms,
    ]);
}
// public function search(Request $request, RoomFilterService $roomFilterService, ErgonomicRepository $ergonomicRepository): Response
// {
//     $title = $request->query->get('title');
//     $capacity = $request->query->get('capacity');
//     $price = $request->query->get('price');
//     $ergonomics = $request->query->get('ergonomics');
//     $equipment = $request->query->get('equipment');

//     $rooms = $roomFilterService->filter($title, $capacity, $price, $ergonomics, $equipment);

//     return $this->render('rooms/rooms.html.twig', [
//         'rooms' => $rooms,
//         'ergonomics' => $ergonomics,
//     ]);
// }

/*$existingBookings = $bookingRepository->findOverlappingBookings($room, $dateIn, $dateOut);

            if (!empty($existingBookings)) {
                // Si des réservations conflictuelles existent, informer l'utilisateur avec un message d'erreur
                $firstConflictReservation = $existingBookings[0];
                $conflictStartDate = $firstConflictReservation->getDateIn()->format('d-m-Y');
                $conflictEndDate = $firstConflictReservation->getDateOut()->format('d-m-Y');
                // $conflictRoomName = $firstConflictReservation->getRoom()->getTitle();
            
                $errorMessage = "Désolé, la salle est déjà réservée du " . $conflictStartDate . " au " . $conflictEndDate . ". Veuillez choisir une autre date ou salle.";
                $this->addFlash('errorResa', $errorMessage);
            
                // Retourner la vue avec le message d'erreur et d'autres données nécessaires
                return $this->render('rooms/show.html.twig', [
                    'controller_name' => 'PageController',
                    'room' => $room,
                    'errors' => [],
                    // 'bookingForm' => $form,
                ]);
            }else{
            $booking = $form->getData();
            $booking->setUser($user);
            $booking->addRoom($room);
            $booking->setNumber(substr(uniqid('booking-', true), 0, 15));
            $booking->setStatus(null);
            
            $em->persist($booking);
            $em->flush();

            $this->addFlash('success', 'Booking created successfully. An confirmation email has been send. You can update or delete this booking in your profile');


            return $this->redirectToRoute('room_show', ['id' => $id,'bookingForm' => $form->createView(),],);
        }*/
   
}
  
    


