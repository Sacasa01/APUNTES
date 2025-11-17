<?php

namespace AP51\Entity;

use AP51\Repository\OrderRepository;
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

#[Entity(repositoryClass: OrderRepository::class)]
#[Table(name: 'PEDIDO')]
class Order
{
    #[Id]
    #[GeneratedValue('NONE')]
    #[Column(name: 'PEDIDO_NUM', type: 'integer')]
    private int $id;

    #[Column(name: 'PEDIDO_FECHA', type: 'date', nullable: true)]
    private ?\DateTime $orderDate;

    #[Column(name: 'PEDIDO_TIPO', type: 'string', nullable: true, columnDefinition: "ENUM('A', 'B', 'C')")]
    private ?string $orderType;

    #[ManyToOne(targetEntity: Client::class, inversedBy: 'orders')]
    #[JoinColumn(name: 'CLIENTE_COD', referencedColumnName: 'CLIENTE_COD', nullable: false)]
    private Client $customer;

    #[Column(name: 'FECHA_ENVIO', type: 'date', nullable: true)]
    private ?\DateTime $shippingDate;

    #[Column(name: 'TOTAL', type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private ?float $total;

    #[OneToMany(targetEntity: OrderDetail::class, mappedBy: 'order')]
    private Collection $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOrderDate(): ?\DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    public function getOrderType(): ?string
    {
        return $this->orderType;
    }

    public function setOrderType(?string $orderType): void
    {
        $this->orderType = $orderType;
    }

    public function getCustomer(): Client
    {
        return $this->customer;
    }

    public function setCustomer(Client $customer): void
    {
        $this->customer = $customer;
    }

    public function getShippingDate(): ?\DateTime
    {
        return $this->shippingDate;
    }

    public function setShippingDate(?\DateTime $shippingDate): void
    {
        $this->shippingDate = $shippingDate;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function setDetails(Collection $details): void
    {
        $this->details = $details;
    }
}