<?php

namespace App\Entity;

use App\Repository\SoundRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SoundRepository::class)]
class Sound
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'sounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'sounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Style $style = null;

    /**
     * @var Collection<int, CustomSound>
     */
    #[ORM\OneToMany(targetEntity: CustomSound::class, mappedBy: 'sound')]
    private Collection $customSounds;

    /**
     * @var Collection<int, BillingSound>
     */
    #[ORM\OneToMany(targetEntity: BillingSound::class, mappedBy: 'sound')]
    private Collection $billingSounds;

    public function __construct()
    {
        $this->customSounds = new ArrayCollection();
        $this->billingSounds = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStyle(): ?Style
    {
        return $this->style;
    }

    public function setStyle(?Style $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
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
            $customSound->setSound($this);
        }

        return $this;
    }

    public function removeCustomSound(CustomSound $customSound): static
    {
        if ($this->customSounds->removeElement($customSound)) {
            // set the owning side to null (unless already changed)
            if ($customSound->getSound() === $this) {
                $customSound->setSound(null);
            }
        }

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
            $billingSound->setSound($this);
        }

        return $this;
    }

    public function removeBillingSound(BillingSound $billingSound): static
    {
        if ($this->billingSounds->removeElement($billingSound)) {
            // set the owning side to null (unless already changed)
            if ($billingSound->getSound() === $this) {
                $billingSound->setSound(null);
            }
        }

        return $this;
    }
}
