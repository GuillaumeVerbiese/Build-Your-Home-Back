<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscountRepository::class)
 */
class Discount
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
    private $discount_name;

    /**
     * @ORM\Column(type="float")
     */
    private $discount_rate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $discount_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $discount_updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscountName(): ?string
    {
        return $this->discount_name;
    }

    public function setDiscountName(string $discount_name): self
    {
        $this->discount_name = $discount_name;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->discount_rate;
    }

    public function setDiscountRate(float $discount_rate): self
    {
        $this->discount_rate = $discount_rate;

        return $this;
    }

    public function getDiscountCreatedAt(): ?\DateTimeInterface
    {
        return $this->discount_createdAt;
    }

    public function setDiscountCreatedAt(\DateTimeInterface $discount_createdAt): self
    {
        $this->discount_createdAt = $discount_createdAt;

        return $this;
    }

    public function getDiscountUpdatedAt(): ?\DateTimeInterface
    {
        return $this->discount_updatedAt;
    }

    public function setDiscountUpdatedAt(?\DateTimeInterface $discount_updatedAt): self
    {
        $this->discount_updatedAt = $discount_updatedAt;

        return $this;
    }
}
