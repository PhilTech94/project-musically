<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 100)]
    private ?string $mail = null;

    /**
     * @var Collection<int, Quote>
     */
    #[ORM\OneToMany(targetEntity: Quote::class, mappedBy: 'customer')]
    private Collection $quotes;

    /**
     * @var Collection<int, CustomSound>
     */
    #[ORM\OneToMany(targetEntity: CustomSound::class, mappedBy: 'customer')]
    private Collection $customSounds;

    public function __construct()
    {
        $this->quotes = new ArrayCollection();
        $this->customSounds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, Quote>
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): static
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes->add($quote);
            $quote->setCustomer($this);
        }

        return $this;
    }

    public function removeQuote(Quote $quote): static
    {
        if ($this->quotes->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getCustomer() === $this) {
                $quote->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CustomSound>
     */
    public function getCustomSounds(): Collection
    {
        return $this->customSounds;
    }

    public function addCustomSound(CustomSound $customSound): static
    {
        if (!$this->customSounds->contains($customSound)) {
            $this->customSounds->add($customSound);
            $customSound->setCustomer($this);
        }

        return $this;
    }

    public function removeCustomSound(CustomSound $customSound): static
    {
        if ($this->customSounds->removeElement($customSound)) {
            // set the owning side to null (unless already changed)
            if ($customSound->getCustomer() === $this) {
                $customSound->setCustomer(null);
            }
        }

        return $this;
    }
}
