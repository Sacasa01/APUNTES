<?php

namespace AP51\Entity;

use AP51\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: OrderDetailRepository::class)]
#[Table(name: 'DETALLE')]
class OrderDetail
{
    #[Id]
    #[GeneratedValue('NONE')]
    #[Column(name: 'DETALLE_NUM',type: 'integer')]
    private int $id;

    #[Id]
    #[ManyToOne(targetEntity: Order::class, inversedBy: 'details')]
    #[JoinColumn(name: 'PEDIDO_NUM', referencedColumnName: 'PEDIDO_NUM', nullable: false)]
    private Order $order;

    #[ManyToOne(targetEntity: Product::class, inversedBy: 'details')]
    #[JoinColumn(name: 'PROD_NUM', referencedColumnName: 'PROD_NUM', nullable: false)]
    private Product $product;

    #[Column(name: 'PRECIO_VENTA', type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private ?float $price;

    #[Column(name: 'CANTIDAD', type: 'integer', nullable: true)]
    private ?int $quantity;

    #[Column(name: 'IMPORTE', type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private ?float $amount;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }
}