<?php

namespace App\Entity;

use App\Entity\Behavior\TimestampableTrait;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass:UserRepository::class)]
#[ORM\Table(name:"`users`")]
#[UniqueEntity("email")]
#[UniqueEntity("username")]
class User extends BaseUser
{

    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type:"integer")]
    protected $id;

    #[ORM\Column(type:"boolean", nullable: true)]
    protected bool $sendNotifications = true;

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
