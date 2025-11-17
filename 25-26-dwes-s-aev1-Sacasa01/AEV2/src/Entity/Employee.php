<?php

namespace AEV2\Entity;

use AEV2\Repository\EmployeeRepository;
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

#[Entity(repositoryClass: EmployeeRepository::class)]
#[Table(name: 'EMP')]
class Employee
{
    #[Id]
    #[GeneratedValue(strategy: "NONE")]
    #[Column(name: 'EMP_NO', type: 'smallint', options: ['unsigned' => true])]  // ✅ MAYÚSCULAS + smallint
    private int $id;

    #[Column(name: 'APELLIDOS', type: 'string', length: 10)]  // ✅ MAYÚSCULAS
    private string $last_name;

    #[Column(name: 'OFICIO', type: 'string', length: 10, nullable: true)]  // ✅ MAYÚSCULAS
    private ?string $job = null;

    #[Column(name: 'FECHA_ALTA', type: 'date', nullable: true)]  // ✅ MAYÚSCULAS
    private ?\DateTime $hireDate = null;

    #[Column(name: 'SALARIO', type: 'integer', nullable: true, options: ['unsigned' => true])]  // ✅ MAYÚSCULAS
    private ?int $salary = null;

    #[Column(name: 'COMISION', type: 'integer', nullable: true, options: ['unsigned' => true])]  // ✅ MAYÚSCULAS
    private ?int $comission = null;

    #[ManyToOne(targetEntity: Department::class, inversedBy: 'employees')]
    #[JoinColumn(name: 'DEPT_NO', referencedColumnName: 'DEPT_NO', nullable: false)]  // ✅ MAYÚSCULAS
    private Department $department;  // ✅ Mejor nombre que $dept_no

    #[ManyToOne(targetEntity: Employee::class, inversedBy: 'subordinates')]
    #[JoinColumn(name: 'JEFE', referencedColumnName: 'EMP_NO', nullable: true)]  // ✅ MAYÚSCULAS + EMP_NO
    private ?Employee $manager = null;  // ✅ Tipo Employee, no int

    #[OneToMany(targetEntity: Employee::class, mappedBy: 'manager')]
    private Collection $subordinates;  // ✅ Sin nullable

    #[OneToMany(targetEntity: Client::class, mappedBy: 'employee')]  // ✅ Cambiado de 'repr_cod' a 'employee'
    private Collection $clients;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->subordinates = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): void
    {
        $this->job = $job;
    }

    public function getHireDate(): ?\DateTime
    {
        return $this->hireDate;
    }

    public function setHireDate(?\DateTime $hireDate): void
    {
        $this->hireDate = $hireDate;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(?int $salary): void
    {
        $this->salary = $salary;
    }

    public function getComission(): ?int
    {
        return $this->comission;
    }

    public function setComission(?int $comission): void
    {
        $this->comission = $comission;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }

    public function getManager(): ?Employee  // ✅ Tipo Employee
    {
        return $this->manager;
    }

    public function setManager(?Employee $manager): void  // ✅ Tipo Employee
    {
        $this->manager = $manager;
    }

    public function getSubordinates(): Collection
    {
        return $this->subordinates;
    }

    public function addSubordinate(Employee $subordinate): void
    {
        if (!$this->subordinates->contains($subordinate)) {
            $this->subordinates[] = $subordinate;
            $subordinate->setManager($this);
        }
    }

    public function removeSubordinate(Employee $subordinate): void
    {
        if ($this->subordinates->removeElement($subordinate)) {
            if ($subordinate->getManager() === $this) {
                $subordinate->setManager(null);
            }
        }
    }

    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): void
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setEmployee($this);
        }
    }

    public function removeClient(Client $client): void
    {
        if ($this->clients->removeElement($client)) {
            if ($client->getEmployee() === $this) {
                $client->setEmployee(null);
            }
        }
    }
}