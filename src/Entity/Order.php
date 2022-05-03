<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $order_ref;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $order_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $order_updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $order_user;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveriesFees::class, inversedBy="orders")
     */
    private $order_deliveries;

    /**
     * @ORM\OneToMany(targetEntity=Orderlist::class, mappedBy="orderlist_order")
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

    public function getOrderRef(): ?string
    {
        return $this->order_ref;
    }

    public function setOrderRef(string $order_ref): self
    {
        $this->order_ref = $order_ref;

        return $this;
    }

    public function getOrderStatus(): ?int
    {
        return $this->order_status;
    }

    public function setOrderStatus(int $order_status): self
    {
        $this->order_status = $order_status;

        return $this;
    }

    public function getOrderCreatedAt(): ?\DateTimeInterface
    {
        return $this->order_createdAt;
    }

    public function setOrderCreatedAt(\DateTimeInterface $order_createdAt): self
    {
        $this->order_createdAt = $order_createdAt;

        return $this;
    }

    public function getOrderUpdatedAt(): ?\DateTimeInterface
    {
        return $this->order_updatedAt;
    }

    public function setOrderUpdatedAt(?\DateTimeInterface $order_updatedAt): self
    {
        $this->order_updatedAt = $order_updatedAt;

        return $this;
    }

    public function getOrderUser(): ?User
    {
        return $this->order_user;
    }

    public function setOrderUser(?User $order_user): self
    {
        $this->order_user = $order_user;

        return $this;
    }

    public function getOrderDeliveries(): ?DeliveriesFees
    {
        return $this->order_deliveries;
    }

    public function setOrderDeliveries(?DeliveriesFees $order_deliveries): self
    {
        $this->order_deliveries = $order_deliveries;

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
