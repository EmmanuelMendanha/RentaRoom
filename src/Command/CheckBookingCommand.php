<?php

namespace App\Command;
use App\Repository\BookingRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Booking;


#[AsCommand(
    name: 'CheckBookingcommand',
    description: 'Add a short description for your command',
)]
class CheckBookingCommand extends Command
{
    protected static $defaultName = 'app:check-reservations';
    private $bookingRepository;
    private $mailer;
    public function __construct(BookingRepository $bookingRepository, MailerInterface $mailer)
    {
        $this->bookingRepository = $bookingRepository;
        $this->mailer = $mailer;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Check pending pre-reservations and notify admin if needed.')
            ->setHelp('This command checks pending pre-reservations and notifies admin if needed.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pendingBookings = $this->bookingRepository->findPendingBookings();

        foreach ($pendingBookings as $bookings) {
            // Vérifier si la pré-réservation est en attente depuis plus de 5 jours
            if ($bookings->getCreatedAt()->diff(new \DateTime())->days >= 5) {
                // Envoyer une notification à l'administrateur
                $this->sendNotificationToAdmin($bookings);
            }
        }

        $output->writeln('Pre-reservation check completed.');
        return Command::SUCCESS;
    }
    private function sendNotificationToAdmin($bookings)
    {
        $email = (new Email())
            ->from('RentaRoom@contact.fr')
            ->to('admin@admin.fr')
            ->subject('Booking en attente')
            ->text('Un Booking est en attente depuis plus de 5 jours. Veuillez la confirmer ou l\'annuler.');

        $this->mailer->send($email);
    }
}
