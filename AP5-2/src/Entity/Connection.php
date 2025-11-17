<?php

namespace AP52\Entity;

use AP52\Repository\ConnectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ConnectionRepository::class)]
#[Table(name: 'connections')]
class Connection
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[Column(name: 'ip', type: Types::STRING, length: 39)]
    private string $ip;

    #[Column(name: 'date_connection', type: Types::DATETIME_MUTABLE)]
    private \DateTime $dateConnection;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'connections')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private User $user;

    #[ManyToOne(targetEntity: Server::class, inversedBy: 'connections')]
    #[JoinColumn(name: 'server_id', referencedColumnName: 'id', nullable: false)]
    private Server $server;

    public function getId(): int
    {
        return $this->id;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    public function getDateConnection(): \DateTime
    {
        return $this->dateConnection;
    }

    public function setDateConnection(\DateTime $dateConnection): void
    {
        $this->dateConnection = $dateConnection;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function setServer(Server $server): void
    {
        $this->server = $server;
    }
}