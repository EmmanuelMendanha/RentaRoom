<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
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

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'booking_users')]
    private Collection $users;

    // #[ORM\Column]
    // private ?\DateTimeImmutable $created_at = null;


    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

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
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setBookingUsers($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getBookingUsers() === $this) {
                $user->setBookingUsers(null);
            }
        }

        return $this;
    }

    // public function getCreatedAt(): ?\DateTimeImmutable
    // {
    //     return $this->created_at;
    // }

    // public function setCreatedAt(\DateTimeImmutable $created_at): static
    // {
    //     $this->created_at = $created_at;

    //     return $this;
    // }
}
