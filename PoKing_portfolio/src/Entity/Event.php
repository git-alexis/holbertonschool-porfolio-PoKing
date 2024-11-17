<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Place $place = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $season = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startingDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $finishDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $startingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $finishTime = null;

    #[ORM\Column]
    private ?int $stack = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registrationOpeningDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registrationClosingDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $registrationOpeningTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $registrationClosingTime = null;

    /**
     * @var Collection<int, Rancking>
     */
    #[ORM\OneToMany(targetEntity: Rancking::class, mappedBy: 'event')]
    private Collection $ranckings;

    /**
     * @var Collection<int, Registration>
     */
    #[ORM\OneToMany(targetEntity: Registration::class, mappedBy: 'event')]
    private Collection $registrations;

    // Constructor of the class
    public function __construct()
    {
        $this->ranckings = new ArrayCollection(); // Initializes the collection of rankings
        $this->registrations = new ArrayCollection(); // Initializes the collection of registrations
    }

    // Retrieves the unique identifier
    public function getId(): ?int
    {
        return $this->id;
    }

    // Retrieves the place
    public function getPlace(): ?Place
    {
        return $this->place;
    }

    // Sets the place
    public function setPlace(?Place $place): static
    {
        $this->place = $place;

        return $this;
    }

    // Retrieves the contact
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    // Sets the contact
    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    // Retrieves the season
    public function getSeason(): ?string
    {
        return $this->season;
    }

    // Sets the season
    public function setSeason(?string $season): static
    {
        $this->season = $season;

        return $this;
    }

    // Retrieves the label
    public function getLabel(): ?string
    {
        return $this->label;
    }

    // Sets the label
    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    // Retrieves the starting date
    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    // Sets the starting date
    public function setStartingDate(\DateTimeInterface $startingDate): static
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    // Retrieves the finish date
    public function getFinishDate(): ?\DateTimeInterface
    {
        return $this->finishDate;
    }

    // Sets the finish date
    public function setFinishDate(\DateTimeInterface $finishDate): static
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    // Retrieves the starting time
    public function getStartingTime(): ?\DateTimeInterface
    {
        return $this->startingTime;
    }

    // Sets the starting time
    public function setStartingTime(\DateTimeInterface $startingTime): static
    {
        $this->startingTime = $startingTime;

        return $this;
    }

    // Retrieves the finish time
    public function getFinishTime(): ?\DateTimeInterface
    {
        return $this->finishTime;
    }

    // Sets the finish time
    public function setFinishTime(\DateTimeInterface $finishTime): static
    {
        $this->finishTime = $finishTime;

        return $this;
    }

    // Retrieves the stack (number of chips)
    public function getStack(): ?int
    {
        return $this->stack;
    }

    // Sets the stack (number of chips)
    public function setStack(int $stack): static
    {
        $this->stack = $stack;

        return $this;
    }

    // Retrieves the comment
    public function getComment(): ?string
    {
        return $this->comment;
    }

    // Sets the comment
    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    // Retrieves the registration opening date
    public function getRegistrationOpeningDate(): ?\DateTimeInterface
    {
        return $this->registrationOpeningDate;
    }

    // Sets the registration opening date
    public function setRegistrationOpeningDate(\DateTimeInterface $registrationOpeningDate): static
    {
        $this->registrationOpeningDate = $registrationOpeningDate;

        return $this;
    }

    // Retrieves the registration closing date
    public function getRegistrationClosingDate(): ?\DateTimeInterface
    {
        return $this->registrationClosingDate;
    }

    // Sets the registration closing date
    public function setRegistrationClosingDate(\DateTimeInterface $registrationClosingDate): static
    {
        $this->registrationClosingDate = $registrationClosingDate;

        return $this;
    }

    // Retrieves the registration opening time
    public function getRegistrationOpeningTime(): ?\DateTimeInterface
    {
        return $this->registrationOpeningTime;
    }

    // Sets the registration opening time
    public function setRegistrationOpeningTime(\DateTimeInterface $registrationOpeningTime): static
    {
        $this->registrationOpeningTime = $registrationOpeningTime;

        return $this;
    }

    // Retrieves the registration closing time
    public function getRegistrationClosingTime(): ?\DateTimeInterface
    {
        return $this->registrationClosingTime;
    }

    // Sets the registration closing time
    public function setRegistrationClosingTime(\DateTimeInterface $registrationClosingTime): static
    {
        $this->registrationClosingTime = $registrationClosingTime;

        return $this;
    }

    /**
     * @return Collection<int, Rancking> // Returns a collection of ranking objects
     */
    public function getRanckings(): Collection
    {
        return $this->ranckings;
    }

    // Adds a ranking to the collection
    public function addRancking(Rancking $rancking): static
    {
        if (!$this->ranckings->contains($rancking)) {
            $this->ranckings->add($rancking);
            $rancking->setEvent($this);
        }

        return $this;
    }

    // Removes a ranking from the collection
    public function removeRancking(Rancking $rancking): static
    {
        if ($this->ranckings->removeElement($rancking)) {
            // set the owning side to null (unless already changed)
            if ($rancking->getEvent() === $this) {
                $rancking->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Registration> // Returns a collection of registration objects
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    // Adds a registration to the collection
    public function addRegistration(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setEvent($this);
        }

        return $this;
    }

    // Removes a registration from the collection
    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getEvent() === $this) {
                $registration->setEvent(null);
            }
        }

        return $this;
    }
}
