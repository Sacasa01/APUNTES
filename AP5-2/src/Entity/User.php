<?php

namespace AP52\Entity;

use AP52\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'users')]
class User
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[Column(name: 'username', type: Types::STRING, length: 30, unique: true)]
    private string $username;

    #[Column(name: 'name', type: Types::STRING, length: 30)]
    private string $name;

    #[Column(name: 'first_subname', type: Types::STRING, length: 100)]
    private string $firstSubname;

    #[Column(name: 'second_subname', type: Types::STRING, length: 100, nullable: true)]
    private ?string $secondSubname;

    #[Column(name: 'address', type: Types::STRING, length: 250, nullable: true)]
    private ?string $address;

    #[Column(name: 'telephone', type: Types::STRING, length: 13, nullable: true)]
    private ?string $telephone;

    #[Column(name: 'city', type: Types::STRING, length: 250, nullable: true)]
    private ?string $city;

    #[Column(name: 'country', type: Types::STRING, length: 4)]
    private string $country;

    #[Column(name: 'observation', type: Types::TEXT, nullable: true)]
    private ?string $observation;

    #[Column(name: 'email', type: Types::STRING, length: 250, unique: true)]
    private string $email;

    #[OneToMany(targetEntity: Connection::class, mappedBy: 'user')]
    private Collection $connections;

    public function __construct()
    {
        $this->connections = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFirstSubname(): string
    {
        return $this->firstSubname;
    }

    public function setFirstSubname(string $firstSubname): void
    {
        $this->firstSubname = $firstSubname;
    }

    public function getSecondSubname(): ?string
    {
        return $this->secondSubname;
    }

    public function setSecondSubname(?string $secondSubname): void
    {
        $this->secondSubname = $secondSubname;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): void
    {
        $this->observation = $observation;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getConnections(): Collection
    {
        return $this->connections;
    }

    public function addConnection(Connection $connection): void
    {
        if (!$this->connections->contains($connection)) {
            $this->connections->add($connection);
            $connection->setUser($this);
        }
    }

    public function removeConnection(Connection $connection): void
    {
        if ($this->connections->contains($connection)) {
            $this->connections->removeElement($connection);
        }
    }
}