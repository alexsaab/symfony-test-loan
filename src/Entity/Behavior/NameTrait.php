<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait NameTrait
{

    #[ORM\Column(type: 'string', length: 255)]
    protected $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
