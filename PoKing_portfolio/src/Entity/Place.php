<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $postcode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'place')]
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

    // Retrieves the address
    public function getAddress(): ?string
    {
        return $this->address;
    }

    // Sets the address
    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    // Retrieves the postcode
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    // Sets the postcode
    public function setPostcode(string $postcode): static
    {
        $this->postcode = $postcode;

        return $this;
    }

    // Retrieves the city
    public function getCity(): ?string
    {
        return $this->city;
    }

    // Sets the city
    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Event> // Retrieves the collection of events
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    // Adds an event to the collection of events
    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setPlace($this);
        }

        return $this;
    }

    // Removes an event from the collection of events
    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getPlace() === $this) {
                $event->setPlace(null);
            }
        }

        return $this;
    }
}
