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
     * @Groups("readUser")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     * @Groups("readUser")
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
     * @Groups("readUser")
     */
    private $deliveries;

    /**
     * @ORM\OneToMany(targetEntity=Orderlist::class, mappedBy="order")
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     * @Groups("readUser")
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

   

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDeliveries(): ?DeliveriesFees
    {
        return $this->deliveries;
    }

    public function setDeliveries(?DeliveriesFees $deliveries): self
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
            $orderlist->setOrder($this);
        }

        return $this;
    }

    public function removeOrderlist(Orderlist $orderlist): self
    {
        if ($this->orderlists->removeElement($orderlist)) {
            // set the owning side to null (unless already changed)
            if ($orderlist->getOrder() === $this) {
                $orderlist->setOrder(null);
            }
        }

        return $this;
    }
}
