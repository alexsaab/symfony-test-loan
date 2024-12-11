<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait AddressTrait
{

    #[ORM\Column(type: 'string', length: 255)]
    protected $address = null;

    #[ORM\Column(type: 'string', length: 50)]
    protected $postalCode = null;

    #[ORM\Column(type: 'string', length: 100)]
    protected $city = null;


    #[ORM\Column(type: 'string', length: 100)]
    protected $state = null;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }


}
