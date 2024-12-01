<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass: ClientRepository::class)]
 * @ORM\Table(name="`users`")
 *
 * @Constraints\UniqueEntity("email")
 * @Constraints\UniqueEntity("username")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $sendNotifications = true;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime|null
     */
    protected $updatedAt;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function isSendNotifications(): ?bool
    {
        return $this->sendNotifications;
    }

    /**
     * @param bool $sendNotifications
     */
    public function setSendNotifications(?bool $sendNotifications): void
    {
        $this->sendNotifications = $sendNotifications;
    }

    public function setPlainPassword($password)
    {
        $this->updatedAt = new \DateTime();

        return parent::setPlainPassword($password);
    }
}
