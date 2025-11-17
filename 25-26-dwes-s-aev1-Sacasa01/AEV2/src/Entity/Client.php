<?php

namespace AEV2\Entity;

use AEV2\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ClientRepository::class)]
#[Table(name: 'CLIENTE')]
class Client
{
    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'CLIENTE_COD', type: 'integer', options: ['unsigned' => true])]
    private int $client_cod;

    #[Column(name: 'NOMBRE', type: 'string', length: 45)]
    private string $name;

    #[Column(name: 'DIREC', type: 'string', length: 40)]
    private string $address;

    #[Column(name: 'CIUDAD', type: 'string', length: 30)]
    private string $city;

    #[Column(name: 'ESTADO', type: 'string', length: 2, nullable: true)]
    private ?string $status = null;

    #[Column(name: 'COD_POSTAL', type: 'string', length: 9)]
    private string $zip_code;

    #[Column(name: 'AREA', type: 'smallint', nullable: true)]
    private ?int $area = null;

    #[Column(name: 'TELEFONO', type: 'string', length: 9, nullable: true)]
    private ?string $phone_number = null;

    #[Column(name: 'LIMITE_CREDITO', type: 'decimal', precision: 9, scale: 2, nullable: true, options: ['unsigned' => true])]
    private ?float $credit_limit = null;

    #[Column(name: 'OBSERVACIONES', type: 'text', nullable: true)]
    private ?string $observations = null;

    #[ManyToOne(targetEntity: Employee::class, inversedBy: 'clients')]
    #[JoinColumn(name: 'REPR_COD', referencedColumnName: 'EMP_NO')]
    private ?Employee $employee = null;

    #[OneToMany(targetEntity: Order::class, mappedBy: 'client')]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->client_cod;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getZipCode(): string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): void
    {
        $this->zip_code = $zip_code;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(?int $area): void
    {
        $this->area = $area;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    public function getCreditLimit(): ?float
    {
        return $this->credit_limit;
    }

    public function setCreditLimit(?float $credit_limit): void
    {
        $this->credit_limit = $credit_limit;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): void
    {
        $this->observations = $observations;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): void
    {
        $this->employee = $employee;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): void
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setClient($this);
        }
    }

    public function removeOrder(Order $order): void
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getClient() === $this) {
                $order->setClient(null);
            }
        }
    }
}