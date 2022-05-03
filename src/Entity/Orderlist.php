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
    private $orderlist_created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderlist_quantity;

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

    public function getOrderlistCreatedAt(): ?\DateTimeInterface
    {
        return $this->orderlist_created_at;
    }

    public function setOrderlistCreatedAt(\DateTimeInterface $orderlist_created_at): self
    {
        $this->orderlist_created_at = $orderlist_created_at;

        return $this;
    }

    public function getOrderlistQuantity(): ?int
    {
        return $this->orderlist_quantity;
    }

    public function setOrderlistQuantity(int $orderlist_quantity): self
    {
        $this->orderlist_quantity = $orderlist_quantity;

        return $this;
    }
}
