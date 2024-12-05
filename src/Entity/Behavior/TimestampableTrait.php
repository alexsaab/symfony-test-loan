<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected \DateTime|null $createdAt;


    #[ORM\Column(type: 'datetime', nullable: true)]
    protected \DateTime|null $updatedAt;

    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
