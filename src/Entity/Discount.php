<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_discount")
     * @Groups("read_discount")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_discount")
     * @Groups("read_discount")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     * 
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_discount")
     * @Groups("read_discount")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_discount")
     * @Groups("read_discount")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="discount")
     * 
     * 
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscountName(): ?string
    {
        return $this->name;
    }

    public function setDiscountName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->rate;
    }

    public function setDiscountRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getDiscountCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setDiscountCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDiscountUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setDiscountUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setArticleDiscount($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticleDiscount() === $this) {
                $article->setArticleDiscount(null);
            }
        }

        return $this;
    }
}
