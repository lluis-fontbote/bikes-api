<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\BikeRepository;
use App\Validator\NotUpdatable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
#[ApiResource]
#[Delete]
#[Get]
#[Patch(validationContext: ['groups' => ['Default', 'patchValidation']])]
#[GetCollection]
#[Post(validationContext: ['groups' => ['Default', 'postValidation']])]
#[
    ApiFilter(
        SearchFilter::class,
        properties: [
            'model' => SearchFilterInterface::STRATEGY_PARTIAL,
            'cylinderCapacity' => SearchFilterInterface::STRATEGY_EXACT,
            'brand' => SearchFilterInterface::STRATEGY_PARTIAL,
            'type' => SearchFilterInterface::STRATEGY_EXACT,
            'weight' => SearchFilterInterface::STRATEGY_EXACT,
        ]
    ),
    ApiFilter(
        OrderFilter::class,
        properties: ['id', 'model', 'brand', 'cylinderCapacity', 'weight', 'type'],
    ),
]
class Bike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $model = null;

    #[Assert\NotNull]
    #[ORM\Column]
    private ?int $cylinderCapacity = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    #[ORM\Column(length: 40)]
    private ?string $brand = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\Count(max: 20)]
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

    #[Assert\NotNull(groups: ['postValidation'])]
    #[NotUpdatable(groups: ['patchValidation'])]
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
