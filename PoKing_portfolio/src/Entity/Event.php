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
    private ?place $place = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?contact $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $season = null;

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

    public function __construct()
    {
        $this->ranckings = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?place
    {
        return $this->place;
    }

    public function setPlace(?place $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getContact(): ?contact
    {
        return $this->contact;
    }

    public function setContact(?contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(?string $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(\DateTimeInterface $startingDate): static
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    public function getFinishDate(): ?\DateTimeInterface
    {
        return $this->finishDate;
    }

    public function setFinishDate(\DateTimeInterface $finishDate): static
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    public function getStartingTime(): ?\DateTimeInterface
    {
        return $this->startingTime;
    }

    public function setStartingTime(\DateTimeInterface $startingTime): static
    {
        $this->startingTime = $startingTime;

        return $this;
    }

    public function getFinishTime(): ?\DateTimeInterface
    {
        return $this->finishTime;
    }

    public function setFinishTime(\DateTimeInterface $finishTime): static
    {
        $this->finishTime = $finishTime;

        return $this;
    }

    public function getStack(): ?int
    {
        return $this->stack;
    }

    public function setStack(int $stack): static
    {
        $this->stack = $stack;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRegistrationOpeningDate(): ?\DateTimeInterface
    {
        return $this->registrationOpeningDate;
    }

    public function setRegistrationOpeningDate(\DateTimeInterface $registrationOpeningDate): static
    {
        $this->registrationOpeningDate = $registrationOpeningDate;

        return $this;
    }

    public function getRegistrationClosingDate(): ?\DateTimeInterface
    {
        return $this->registrationClosingDate;
    }

    public function setRegistrationClosingDate(\DateTimeInterface $registrationClosingDate): static
    {
        $this->registrationClosingDate = $registrationClosingDate;

        return $this;
    }

    public function getRegistrationOpeningTime(): ?\DateTimeInterface
    {
        return $this->registrationOpeningTime;
    }

    public function setRegistrationOpeningTime(\DateTimeInterface $registrationOpeningTime): static
    {
        $this->registrationOpeningTime = $registrationOpeningTime;

        return $this;
    }

    public function getRegistrationClosingTime(): ?\DateTimeInterface
    {
        return $this->registrationClosingTime;
    }

    public function setRegistrationClosingTime(\DateTimeInterface $registrationClosingTime): static
    {
        $this->registrationClosingTime = $registrationClosingTime;

        return $this;
    }

    /**
     * @return Collection<int, Rancking>
     */
    public function getRanckings(): Collection
    {
        return $this->ranckings;
    }

    public function addRancking(Rancking $rancking): static
    {
        if (!$this->ranckings->contains($rancking)) {
            $this->ranckings->add($rancking);
            $rancking->setEvent($this);
        }

        return $this;
    }

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
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setEvent($this);
        }

        return $this;
    }

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
