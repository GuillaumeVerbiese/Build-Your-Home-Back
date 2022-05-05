<?php

namespace App\Entity;

use App\Repository\OrderlistRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="orderlists")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $article;

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
        return $this->order;
    }

    public function setOrderlistOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getOrderlistArticle(): ?Article
    {
        return $this->article;
    }

    public function setOrderlistArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getOrderlistCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setOrderlistCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getOrderlistQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setOrderlistQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
