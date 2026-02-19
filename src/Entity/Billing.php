<?php

namespace App\Entity;

use App\Enum\BillingStatus;
use App\Repository\BillingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BillingRepository::class)]
class Billing
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(enumType: BillingStatus::class)]
    private ?BillingStatus $status = null;

    /**
     * @var Collection<int, BillingSound>
     */
    #[ORM\OneToMany(targetEntity: BillingSound::class, mappedBy: 'billing')]
    private Collection $billingSounds;

    public function __construct()
    {
        $this->billingSounds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
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

    public function getStatus(): ?BillingStatus
    {
        return $this->status;
    }

    public function setStatus(BillingStatus $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Collection<int, BillingSound>
     */
    public function getBillingSounds(): Collection
    {
        return $this->billingSounds;
    }

    public function addBillingSound(BillingSound $billingSound): static
    {
        if (!$this->billingSounds->contains($billingSound)) {
            $this->billingSounds->add($billingSound);
            $billingSound->setBilling($this);
        }
        return $this;
    }

    public function removeBillingSound(BillingSound $billingSound): static
    {
        if ($this->billingSounds->removeElement($billingSound)) {
            if ($billingSound->getBilling() === $this) {
                $billingSound->setBilling(null);
            }
        }
        return $this;
    }
}
