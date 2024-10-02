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
    private ?event $event = null;

    #[ORM\ManyToOne(inversedBy: 'ranckings')]
    private ?user $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $season = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column]
    private ?int $rankingPosition = null;

    #[ORM\Column(length: 255)]
    private ?string $eliminatedBy = null;

    #[ORM\Column]
    private ?int $killsNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?event
    {
        return $this->event;
    }

    public function setEvent(?event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getRankingPosition(): ?int
    {
        return $this->rankingPosition;
    }

    public function setRankingPosition(int $rankingPosition): static
    {
        $this->rankingPosition = $rankingPosition;

        return $this;
    }

    public function getEliminatedBy(): ?string
    {
        return $this->eliminatedBy;
    }

    public function setEliminatedBy(string $eliminatedBy): static
    {
        $this->eliminatedBy = $eliminatedBy;

        return $this;
    }

    public function getKillsNumber(): ?int
    {
        return $this->killsNumber;
    }

    public function setKillsNumber(int $killsNumber): static
    {
        $this->killsNumber = $killsNumber;

        return $this;
    }
}
