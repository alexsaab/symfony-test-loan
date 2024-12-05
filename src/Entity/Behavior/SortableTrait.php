<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait SortableTrait
{

    #[ORM\Column(type: 'integer', nullable: true, name:'`order`')]
    private $order;

    public function setOrder(?int $order)
    {
        $this->order = $order;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }
}
