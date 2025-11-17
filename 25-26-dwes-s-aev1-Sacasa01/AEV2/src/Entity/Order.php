<?php

namespace AEV2\Entity;

use AEV2\Repository\OrderRepository;
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
    #[GeneratedValue(strategy: "NONE")]
    #[Column(name: 'PEDIDO_NUM', type: 'smallint', options: ['unsigned' => true])]
    private int $id;

    #[Column(name: 'PEDIDO_FECHA', type: 'date', nullable: true)]
    private ?\DateTime $order_date = null;

    #[Column(name: 'PEDIDO_TIPO', type: 'string', length: 1, nullable: true)]
    private ?string $order_type = null;

    #[Column(name: 'FECHA_ENVIO', type: 'date', nullable: true)]
    private ?\DateTime $ship_date = null;

    #[Column(name: 'TOTAL', type: 'decimal', precision: 8, scale: 2, nullable: true, options: ['unsigned' => true])]
    private ?float $total = null;

    #[ManyToOne(targetEntity: Client::class, inversedBy: 'orders')]
    #[JoinColumn(name: 'CLIENTE_COD', referencedColumnName: 'CLIENTE_COD', nullable: false)]
    private Client $client;

    #[OneToMany(targetEntity: Detail::class, mappedBy: 'numOrder')]
    private Collection $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getOrderNum(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setOrderNum(int $orderNum): void
    {
        $this->id = $orderNum;
    }

    // --- Otros Métodos ---

    public function getOrderDate(): ?\DateTime
    {
        return $this->order_date;
    }

    public function setOrderDate(?\DateTime $order_date): void
    {
        $this->order_date = $order_date;
    }

    public function getOrderType(): ?string
    {
        return $this->order_type;
    }

    public function setOrderType(?string $order_type): void
    {
        $this->order_type = $order_type;
    }

    public function getShipDate(): ?\DateTime
    {
        return $this->ship_date;
    }

    public function setShipDate(?\DateTime $ship_date): void
    {
        $this->ship_date = $ship_date;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): void
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setOrder($this);
        }
    }

    public function removeDetail(Detail $detail): void
    {
        if ($this->details->removeElement($detail)) {
            if ($detail->getOrder() === $this) {
                $detail->setOrder(null);
            }
        }
    }
}