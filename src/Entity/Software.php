<?php

namespace App\Entity;

use App\Repository\SoftwareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoftwareRepository::class)]
class Software
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Room::class, mappedBy: 'software')]
    private Collection $softwares;

    public function __construct()
    {
        $this->softwares = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getSoftwares(): Collection
    {
        return $this->softwares;
    }

    public function addSoftware(Room $software): static
    {
        if (!$this->softwares->contains($software)) {
            $this->softwares->add($software);
        }

        return $this;
    }

    public function removeSoftware(Room $software): static
    {
        $this->softwares->removeElement($software);

        return $this;
    }
}
