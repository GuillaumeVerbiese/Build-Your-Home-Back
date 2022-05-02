<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $brand_name;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $brand_slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $brand_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $brand_updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): ?string
    {
        return $this->brand_name;
    }

    public function setBrandName(string $brand_name): self
    {
        $this->brand_name = $brand_name;

        return $this;
    }

    public function getBrandSlug(): ?string
    {
        return $this->brand_slug;
    }

    public function setBrandSlug(string $brand_slug): self
    {
        $this->brand_slug = $brand_slug;

        return $this;
    }

    public function getBrandCreatedAt(): ?\DateTimeInterface
    {
        return $this->brand_createdAt;
    }

    public function setBrandCreatedAt(\DateTimeInterface $brand_createdAt): self
    {
        $this->brand_createdAt = $brand_createdAt;

        return $this;
    }

    public function getBrandUpdatedAt(): ?\DateTimeInterface
    {
        return $this->brand_updatedAt;
    }

    public function setBrandUpdatedAt(?\DateTimeInterface $brand_updatedAt): self
    {
        $this->brand_updatedAt = $brand_updatedAt;

        return $this;
    }
}
