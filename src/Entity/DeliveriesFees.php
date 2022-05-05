<?php

namespace App\Entity;

use App\Repository\DeliveriesFeesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("browse_deliveryfee")
     * @Groups("read_deliveriesfee")
     * @Groups("browse_order")
     * @Groups("read_order")
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

    public function getDeliveryFeesName(): ?string
    {
        return $this->name;
    }

    public function setDeliveryFeesName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDeliveryFeesPrice(): ?float
    {
        return $this->price;
    }

    public function setDeliveryFeesPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDeliveryFeesCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setDeliveryFeesCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeliveryFeesUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setDeliveryFeesUpdatedAt(?\DateTimeInterface $updatedAt): self
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
            $order->setOrderDeliveries($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getOrderDeliveries() === $this) {
                $order->setOrderDeliveries(null);
            }
        }

        return $this;
    }
}
