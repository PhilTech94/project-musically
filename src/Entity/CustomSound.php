<?php

namespace App\Entity;

use App\Repository\CustomSoundRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CustomSoundRepository::class)]
class CustomSound
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'customSounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'customSounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sound $sound = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

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
}
