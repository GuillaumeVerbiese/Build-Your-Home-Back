<?php

namespace App\Entity;

use App\Repository\VATRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VATRepository::class)
 */
class VAT
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
    private $vat_name;

    /**
     * @ORM\Column(type="float")
     */
    private $vat_rate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $vat_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $vat_updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVatName(): ?string
    {
        return $this->vat_name;
    }

    public function setVatName(string $vat_name): self
    {
        $this->vat_name = $vat_name;

        return $this;
    }

    public function getVatRate(): ?float
    {
        return $this->vat_rate;
    }

    public function setVatRate(float $vat_rate): self
    {
        $this->vat_rate = $vat_rate;

        return $this;
    }

    public function getVatCreatedAt(): ?\DateTimeInterface
    {
        return $this->vat_createdAt;
    }

    public function setVatCreatedAt(\DateTimeInterface $vat_createdAt): self
    {
        $this->vat_createdAt = $vat_createdAt;

        return $this;
    }

    public function getVatUpdatedAt(): ?\DateTimeInterface
    {
        return $this->vat_updatedAt;
    }

    public function setVatUpdatedAt(?\DateTimeInterface $vat_updatedAt): self
    {
        $this->vat_updatedAt = $vat_updatedAt;

        return $this;
    }
}
