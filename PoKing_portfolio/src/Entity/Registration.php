<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $registrationTime = null;

    // Retrieves the unique identifier
    public function getId(): ?int
    {
        return $this->id;
    }

    // Retrieves the event
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    // Sets the event
    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    // Retrieves the user
    public function getUser(): ?User
    {
        return $this->user;
    }

    // Sets the user
    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    // Retrieves the registrationDate
    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    // Sets the registrationDate
    public function setRegistrationDate(\DateTimeInterface $registrationDate): static
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    // Retrieves the registrationTime
    public function getRegistrationTime(): ?\DateTimeInterface
    {
        return $this->registrationTime;
    }

    // Sets the registrationTime
    public function setRegistrationTime(\DateTimeInterface $registrationTime): static
    {
        $this->registrationTime = $registrationTime;

        return $this;
    }
}
