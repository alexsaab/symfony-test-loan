<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer', unique: true)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
