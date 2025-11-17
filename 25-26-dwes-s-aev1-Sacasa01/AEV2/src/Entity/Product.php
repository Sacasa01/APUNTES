<?php

namespace AEV2\Entity;

use AEV2\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ProductRepository::class)]
#[Table(name: 'PRODUCTO')]
class Product
{
    #[Id]
    #[GeneratedValue(strategy: "NONE")]
    #[Column(name: 'PROD_NUM', type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[Column(name: 'DESCRIPCION', type: 'string', length: 30, unique: true)]
    private string $description;

    #[OneToMany(targetEntity: Detail::class, mappedBy: 'product')]
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): void
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setProduct($this);
        }
    }

    public function removeDetail(Detail $detail): void
    {
        if ($this->details->removeElement($detail)) {
            if ($detail->getProduct() === $this) {
                $detail->setProduct(null);
            }
        }
    }
}