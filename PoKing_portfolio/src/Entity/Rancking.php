<?php

namespace App\Entity;

use App\Repository\RanckingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RanckingRepository::class)]
class Rancking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ranckings')]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'ranckings')]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $season = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column]
    private ?int $rankingPosition = null;

    #[ORM\Column]
    private ?int $killsNumber = null;

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

    // Retrieves the points
    public function getPoints(): ?int
    {
        return $this->points;
    }

    // Sets the points
    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    // Retrieves the rankingPosition
    public function getRankingPosition(): ?int
    {
        return $this->rankingPosition;
    }

    // Sets the rankingPosition
    public function setRankingPosition(int $rankingPosition): static
    {
        $this->rankingPosition = $rankingPosition;

        return $this;
    }

    // Retrieves the killsNumber
    public function getKillsNumber(): ?int
    {
        return $this->killsNumber;
    }

    // Sets the killsNumber
    public function setKillsNumber(int $killsNumber): static
    {
        $this->killsNumber = $killsNumber;

        return $this;
    }
}
