<?php

namespace App\Entity;

use App\Repository\BillingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToOne(inversedBy: 'billing', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quote $quote = null;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuote(): ?Quote
    {
        return $this->quote;
    }

    public function setQuote(Quote $quote): static
    {
        $this->quote = $quote;

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
            // set the owning side to null (unless already changed)
            if ($billingSound->getBilling() === $this) {
                $billingSound->setBilling(null);
            }
        }

        return $this;
    }
}
