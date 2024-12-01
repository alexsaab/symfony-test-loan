<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait EnabledTrait
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }
}