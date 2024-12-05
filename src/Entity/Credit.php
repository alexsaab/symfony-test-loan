<?php

namespace App\Entity;

use App\Entity\Behavior\TimestampableTrait;
use App\Repository\CreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{

    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $term = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 4, nullable: false)]
    private ?string $percent = null;

    #[ORM\Column(nullable: false)]
    private ?int $amount;
    #[ORM\Column(length: 20, nullable: false)]
    private ?string $currency = 'USD';

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'credits')]
    private int $clientId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTerm(): ?int
    {
        return $this->term;
    }

    public function setTerm(int $term): static
    {
        $this->term = $term;

        return $this;
    }

    public function getPercent(): ?string
    {
        return $this->percent;
    }

    public function setPercent(string $percent): static
    {
        $this->percent = $percent;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
