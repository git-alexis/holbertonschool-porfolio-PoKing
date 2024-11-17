<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'profile')]
    private Collection $users;

    // Constructor of the class
    public function __construct()
    {
        $this->users = new ArrayCollection(); // Initializes the collection of users
    }

    // Retrieves the unique identifier
    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, User> // Retrieves a collection of user objects
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    // Adds an user to the collection
    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setProfile($this);
        }

        return $this;
    }

    // Removes an user from the collection
    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfile() === $this) {
                $user->setProfile(null);
            }
        }

        return $this;
    }
}
