<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BikeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
#[ApiResource]
class Bike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $model = null;

    #[ORM\Column]
    private ?int $cylinderCapacity = null;

    #[ORM\Column(length: 40)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $extras = [];

    #[ORM\Column(nullable: true)]
    private ?int $weight = null;

    #[Timestampable(on: 'create')]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column]
    private ?bool $limitedEdition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getCylinderCapacity(): ?int
    {
        return $this->cylinderCapacity;
    }

    public function setCylinderCapacity(int $cylinderCapacity): static
    {
        $this->cylinderCapacity = $cylinderCapacity;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * @param string[] $extras
     */
    public function setExtras(array $extras): static
    {
        $this->extras = $extras;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function isLimitedEdition(): ?bool
    {
        return $this->limitedEdition;
    }

    public function setLimitedEdition(bool $limitedEdition): static
    {
        $this->limitedEdition = $limitedEdition;

        return $this;
    }
}
