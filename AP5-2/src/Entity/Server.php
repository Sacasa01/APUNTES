<?php

namespace AP52\Entity;

use AP52\Repository\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ServerRepository::class)]
#[Table(name: 'servers')]
class Server
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[Column(name: 'url', type: Types::STRING, length: 250, unique: true)]
    private string $url;

    #[Column(name: 'country_server', type: Types::STRING, length: 4)]
    private string $countryServer;

    #[Column(name: 'observation', type: Types::TEXT, nullable: true)]
    private ?string $observation;

    #[Column(name: 'domain', type: Types::STRING, length: 250)]
    private string $domain;

    #[Column(name: 'ip', type: Types::STRING, length: 40, nullable: true, unique: true)]
    private ?string $ip;

    #[OneToMany(targetEntity: Connection::class, mappedBy: 'server')]
    private Collection $connections;

    public function __construct()
    {
        $this->connections = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getCountryServer(): string
    {
        return $this->countryServer;
    }

    public function setCountryServer(string $countryServer): void
    {
        $this->countryServer = $countryServer;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): void
    {
        $this->observation = $observation;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    public function getConnections(): Collection
    {
        return $this->connections;
    }

    public function addConnection(Connection $connection): void
    {
        if (!$this->connections->contains($connection)) {
            $this->connections->add($connection);
            $connection->setServer($this);
        }
    }

    public function removeConnection(Connection $connection): void
    {
        if ($this->connections->contains($connection)) {
            $this->connections->removeElement($connection);
        }
    }
}