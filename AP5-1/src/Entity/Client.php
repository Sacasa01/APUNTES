<?php

namespace AP51\Entity;

use AP51\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ClientRepository::class)]
#[Table(name: 'CLIENTE')]
class Client
{
    #[Id]
    #[GeneratedValue('NONE')]
    #[Column(name: 'CLIENTE_COD', type: Types::INTEGER)]
    private int $id;

    #[Column(name: 'NOMBRE', type: Types::STRING, length: 45, unique: true)]
    private string $name;

    #[Column(name: 'DIREC', type: Types::STRING, length: 40)]
    private string $address;

    #[Column(name: 'CIUDAD', type: Types::STRING, length: 30)]
    private string $city;

    #[Column(name: 'ESTADO', type: Types::STRING, length: 2, nullable: true)]
    private ?string $state;

    #[Column(name: 'COD_POSTAL', type: Types::STRING, length: 9)]
    private string $postalCode;

    #[Column(name: 'AREA', type: Types::SMALLINT, nullable: true)]
    private ?int $area;

    #[Column(name: 'TELEFONO', type: Types::STRING, length: 9, nullable: true)]
    private ?string $telephone;

    #[Column(name: 'REPR_COD', type: Types::SMALLINT, nullable: true)]
    private ?int $agent;

    #[Column(name: 'LIMITE_CREDITO', type: Types::DECIMAL, precision: 9, scale: 2, nullable: true)]
    private ?float $creditLimit;

    #[Column(name: 'OBSERVACIONES', type: Types::TEXT, nullable: true)]
    private ?string $observation;

    #[OneToMany(targetEntity: Order::class, mappedBy: 'customer')]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(?int $area): void
    {
        $this->area = $area;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getAgent(): ?int
    {
        return $this->agent;
    }

    public function setAgent(?int $agent): void
    {
        $this->agent = $agent;
    }

    public function getCreditLimit(): ?float
    {
        return $this->creditLimit;
    }

    public function setCreditLimit(?float $creditLimit): void
    {
        $this->creditLimit = $creditLimit;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): void
    {
        $this->observation = $observation;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function setOrders(Collection $orders): void
    {
        $this->orders = $orders;
    }
}