<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Profile $profile = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $resetToken;

    /**
     * @var Collection<int, Rancking>
     */
    #[ORM\OneToMany(targetEntity: Rancking::class, mappedBy: 'user')]
    private Collection $ranckings;

    /**
     * @var Collection<int, Registration>
     */
    #[ORM\OneToMany(targetEntity: Registration::class, mappedBy: 'user')]
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

    // Retrieves the profile
    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    // Sets the profile
    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    // Retrieves the pseudo
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    // Sets the pseudo
    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    // Retrieves the user identifier
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }

    // Retrieves the password
    public function getPassword(): ?string
    {
        return $this->password;
    }

    // Sets the password
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
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

    // Retrieves the email
    public function getMail(): ?string
    {
        return $this->mail;
    }

    // Sets the email
    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    // Retrieves the address
    public function getAddress(): ?string
    {
        return $this->address;
    }

    // Sets the address
    public function setAddress(?string $address): static
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
    public function setPostcode(?string $postcode): static
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
    public function setCity(?string $city): static
    {
        $this->city = $city;

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

    // Retrieves the birthday
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    // Sets the birthday
    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    // Retrieves the roles
    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    // Sets the roles
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    // Retrieves the reset token
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    // Sets the reset token
    public function setResetToken(?string $resetToken): static
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * @return Collection<int, Rancking>  // Returns a collection of ranking objects
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
            $rancking->setUser($this);
        }

        return $this;
    }

    // Removes a ranking from the collection
    public function removeRancking(Rancking $rancking): static
    {
        if ($this->ranckings->removeElement($rancking)) {
            // set the owning side to null (unless already changed)
            if ($rancking->getUser() === $this) {
                $rancking->setUser(null);
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
            $registration->setUser($this);
        }

        return $this;
    }

    // Removes a registration from the collection
    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getUser() === $this) {
                $registration->setUser(null);
            }
        }

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Clean sensible information of the user
    }
}
