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
     */
    private $discount_name;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_discount")
     * @Groups("read_discount")
     * @Groups("read_category_article")
     * 
     */
    private $discount_rate;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_discount")
     * @Groups("read_discount")
     */
    private $discount_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_discount")
     * @Groups("read_discount")
     */
    private $discount_updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="article_discount")
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
        return $this->discount_name;
    }

    public function setDiscountName(string $discount_name): self
    {
        $this->discount_name = $discount_name;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->discount_rate;
    }

    public function setDiscountRate(float $discount_rate): self
    {
        $this->discount_rate = $discount_rate;

        return $this;
    }

    public function getDiscountCreatedAt(): ?\DateTimeInterface
    {
        return $this->discount_createdAt;
    }

    public function setDiscountCreatedAt(\DateTimeInterface $discount_createdAt): self
    {
        $this->discount_createdAt = $discount_createdAt;

        return $this;
    }

    public function getDiscountUpdatedAt(): ?\DateTimeInterface
    {
        return $this->discount_updatedAt;
    }

    public function setDiscountUpdatedAt(?\DateTimeInterface $discount_updatedAt): self
    {
        $this->discount_updatedAt = $discount_updatedAt;

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
