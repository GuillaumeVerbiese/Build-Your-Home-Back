<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $id;

   

    /**
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveriesFees::class, inversedBy="orders")
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $deliveries;

    /**
     * @ORM\OneToMany(targetEntity=Orderlist::class, mappedBy="order")
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $orderlists;

    public function __construct()
    {
        $this->orderlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getOrderStatus(): ?int
    {
        return $this->status;
    }

    public function setOrderStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOrderCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setOrderCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOrderUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setOrderUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getOrderUser(): ?User
    {
        return $this->user;
    }

    public function setOrderUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOrderDeliveries(): ?DeliveriesFees
    {
        return $this->deliveries;
    }

    public function setOrderDeliveries(?DeliveriesFees $deliveries): self
    {
        $this->deliveries = $deliveries;

        return $this;
    }

    /**
     * @return Collection<int, Orderlist>
     */
    public function getOrderlists(): Collection
    {
        return $this->orderlists;
    }

    public function addOrderlist(Orderlist $orderlist): self
    {
        if (!$this->orderlists->contains($orderlist)) {
            $this->orderlists[] = $orderlist;
            $orderlist->setOrderlistOrder($this);
        }

        return $this;
    }

    public function removeOrderlist(Orderlist $orderlist): self
    {
        if ($this->orderlists->removeElement($orderlist)) {
            // set the owning side to null (unless already changed)
            if ($orderlist->getOrderlistOrder() === $this) {
                $orderlist->setOrderlistOrder(null);
            }
        }

        return $this;
    }
}
