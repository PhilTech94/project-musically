<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    /**
     * @var Collection<int, Sound>
     */
    #[ORM\OneToMany(targetEntity: Sound::class, mappedBy: 'category')]
    private Collection $sounds;

    public function __construct()
    {
        $this->sounds = new ArrayCollection();
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

    /**
     * @return Collection<int, Sound>
     */
    public function getSounds(): Collection
    {
        return $this->sounds;
    }

    public function addSound(Sound $sound): static
    {
        if (!$this->sounds->contains($sound)) {
            $this->sounds->add($sound);
            $sound->setCategory($this);
        }

        return $this;
    }

    public function removeSound(Sound $sound): static
    {
        if ($this->sounds->removeElement($sound)) {
            // set the owning side to null (unless already changed)
            if ($sound->getCategory() === $this) {
                $sound->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
