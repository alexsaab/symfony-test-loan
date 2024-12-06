<?php

namespace App\Entity;

use App\Entity\Behavior\TimestampableTrait;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Behavior\AddressTrait;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    use AddressTrait, TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $firstName;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $lastName;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(length: 100, unique: true, nullable: false)]
    private ?string $ssn;

    #[ORM\Column(unique: true, nullable: false)]
    private ?int $fico;

    #[ORM\Column(length: 200, unique: true, nullable: false)]
    private ?string $email;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSsn(): ?string
    {
        return $this->ssn;
    }

    public function setSsn(?string $ssn): static
    {
        $this->ssn = $ssn;

        return $this;
    }

    public function getFico(): ?int
    {
        return $this->fico;
    }

    public function setFico(?int $fico): static
    {
        $this->fico = $fico;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}
