<?php

namespace App\Entity;

use App\Repository\DeliveriesFeesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DeliveriesFeesRepository::class)
 */
class DeliveriesFees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_deliveryfee")
     * @Groups("read_deliveriesfee")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("browse_deliveryfee")
     * @Groups("read_deliveriesfee")
     * @Groups("readUser")
     * 
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("browse_deliveryfee")
     * @Groups("read_deliveriesfee")
     * @Groups("browse_order")
     * @Groups("read_order")
     * @Groups("readUser")
     * 
     * @Assert\NotBlank
     * @Assert\Positive(message="Le prix doit être un nombre positif")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_deliveryfee")
     * @Groups("read_deliveriesfee")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_deliveryfee")
     * @Groups("read_deliveriesfee")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="deliveries")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setDeliveries($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getDeliveries() === $this) {
                $order->setDeliveries(null);
            }
        }

        return $this;
    }
}
