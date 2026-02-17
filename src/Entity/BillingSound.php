<?php

namespace App\Entity;

use App\Repository\BillingSoundRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BillingSoundRepository::class)]
class BillingSound
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'billingSounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sound $sound = null;

    #[ORM\ManyToOne(inversedBy: 'billingSounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Billing $billing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSound(): ?Sound
    {
        return $this->sound;
    }

    public function setSound(?Sound $sound): static
    {
        $this->sound = $sound;

        return $this;
    }

    public function getBilling(): ?Billing
    {
        return $this->billing;
    }

    public function setBilling(?Billing $billing): static
    {
        $this->billing = $billing;

        return $this;
    }
}
