<?php

namespace AEV2\Entity;

use AEV2\Repository\DetailRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: DetailRepository::class)]
#[Table(name: 'DETALLE')]
class Detail
{
    #[Id]
    #[GeneratedValue('NONE')]
    #[Column(name: 'DETALLE_NUM',type: 'integer')]
    private int $numDetail;

    #[Id]
    #[ManyToOne(targetEntity: Order::class, inversedBy: 'details')]
    #[JoinColumn(name: 'PEDIDO_NUM', referencedColumnName: 'PEDIDO_NUM', nullable: false)]
    private Order $numOrder;

    #[ManyToOne(targetEntity: Product::class, inversedBy: 'details')]
    #[JoinColumn(name: 'PROD_NUM', referencedColumnName: 'PROD_NUM', nullable: false)]
    private Product $product;

    #[Column(name: 'PRECIO_VENTA', type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private ?float $price;

    #[Column(name: 'CANTIDAD', type: 'integer', nullable: true)]
    private ?int $quantity;

    #[Column(name: 'IMPORTE', type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private ?float $amount;

    public function getNumDetail(): int
    {
        return $this->numDetail;
    }

    public function getNumOrder(): Order
    {
        return $this->numOrder;
    }

    public function setNumOrder(Order $numOrder): void
    {
        $this->numOrder = $numOrder;
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