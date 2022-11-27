<?php

namespace App\Entity;

use App\Repository\PayTableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
* @SuppressWarnings(PHPMD)
*/
#[ORM\Entity(repositoryClass: PayTableRepository::class)]
class PayTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $hand = null;

    #[ORM\Column]
    private ?int $odds = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHand(): ?string
    {
        return $this->hand;
    }

    public function setHand(string $hand): self
    {
        $this->hand = $hand;

        return $this;
    }

    public function getOdds(): ?int
    {
        return $this->odds;
    }

    public function setOdds(int $odds): self
    {
        $this->odds = $odds;

        return $this;
    }
}
