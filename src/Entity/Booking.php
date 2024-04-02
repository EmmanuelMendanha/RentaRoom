<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


// Définition de la classe Booking et de son repository
#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
// Déclaration des propriétés de la classe   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateIn = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOut = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\ManyToMany(targetEntity: Room::class, mappedBy: 'bookings')]
    private Collection $rooms;

    #[ORM\ManyToOne(inversedBy: 'booking_users')]
    private ?User $user = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Number = null;
 // Constructeur de la classe
    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }
// Getters et setters pour chaque propriété
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateIn(): ?\DateTimeInterface
    {
        return $this->dateIn;
    }

    public function setDateIn(\DateTimeInterface $dateIn): static
    {
        $this->dateIn = $dateIn;

        return $this;
    }

    public function getDateOut(): ?\DateTimeInterface
    {
        return $this->dateOut;
    }

    public function setDateOut(\DateTimeInterface $dateOut): static
    {
        $this->dateOut = $dateOut;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->addBooking($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            $room->removeBooking($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */

    /**
     * @return Collection<int, User>
     */

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->Number;
    }

    public function setNumber(?string $Number): static
    {
        $this->Number = $Number;

        return $this;
    }

   // Méthodes pour convertir les dates en chaînes de caractères
    public function getDateInString(): string
    {
        return $this->getDateIn()->format('d/m/Y');
    }

    // Convert checkout date to string
    public function getDateOutString(): string
    {
        return $this->getDateOut()->format('d/m/Y');
    }
     // Méthode pour obtenir le statut formaté
    public function getFormattedStatus(): string
{
    if ($this->status === null) {
        return 'En attente';
    }

    if ($this->status === '1') {
        return 'Validé';
    }

    if ($this->status === '0') {
        return 'Refusé';
    }

    return $this->status;
}
    // Méthode pour convertir l'objet en chaîne de caractères
    public function __toString(): string
    {
        return $this->getFormattedStatus();
    }

}
