<?php

namespace App\Entity;

use App\Repository\OrderlistRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderlistRepository::class)
 */
class Orderlist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderlists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderlist_order;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="orderlists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderlist_article;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderlistOrder(): ?Order
    {
        return $this->orderlist_order;
    }

    public function setOrderlistOrder(?Order $orderlist_order): self
    {
        $this->orderlist_order = $orderlist_order;

        return $this;
    }

    public function getOrderlistArticle(): ?Article
    {
        return $this->orderlist_article;
    }

    public function setOrderlistArticle(?Article $orderlist_article): self
    {
        $this->orderlist_article = $orderlist_article;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
