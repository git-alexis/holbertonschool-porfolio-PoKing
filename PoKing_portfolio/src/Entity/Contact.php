<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'contact')]
    private Collection $events;

    // Constructor of the class
    public function __construct()
    {
        $this->events = new ArrayCollection(); // Initializes the collection of events
    }

    // Retrieves the unique identifier
    public function getId(): ?int
    {
        return $this->id;
    }

    // Retrieves the name
    public function getName(): ?string
    {
        return $this->name;
    }

    // Sets the name
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    // Retrieves the surname
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    // Sets the surname
    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    // Retrieves the email address
    public function getMail(): ?string
    {
        return $this->mail;
    }

    // Sets the email address
    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    // Retrieves the phone number
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    // Sets the phone number
    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    // Retrieves the role
    public function getRole(): ?string
    {
        return $this->role;
    }

    // Sets the role
    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Event> // Retrieves a collection of Event objects
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    // Adds an event to the list of events
    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setContact($this);
        }

        return $this;
    }

    // Removes an event from the list of events
    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getContact() === $this) {
                $event->setContact(null);
            }
        }

        return $this;
    }
}
