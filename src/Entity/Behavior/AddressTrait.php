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

    public function getAddress(): null
    {
        return $this->address;
    }

    public function setAddress(null $address): void
    {
        $this->address = $address;
    }

    public function getPostalCode(): null
    {
        return $this->postalCode;
    }

    public function setPostalCode(null $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCity(): null
    {
        return $this->city;
    }

    public function setCity(null $city): void
    {
        $this->city = $city;
    }

    public function getState(): null
    {
        return $this->state;
    }

    public function setState(null $state): void
    {
        $this->state = $state;
    }


}
