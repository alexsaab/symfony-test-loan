<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait SortableTrait
{
    /**
     * @var int|null
     * @ORM\Column(type="integer", name="`order`", nullable=true)
     */
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