<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait ContentTrait
{


    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $content;

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }
}
