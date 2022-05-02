<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $article_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $article_description;

    /**
     * @ORM\Column(type="float")
     */
    private $article_price;

    /**
     * @ORM\Column(type="integer")
     */
    private $article_stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $article_picture_link;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $article_slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $article_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $article_updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleName(): ?string
    {
        return $this->article_name;
    }

    public function setArticleName(string $article_name): self
    {
        $this->article_name = $article_name;

        return $this;
    }

    public function getArticleDescription(): ?string
    {
        return $this->article_description;
    }

    public function setArticleDescription(string $article_description): self
    {
        $this->article_description = $article_description;

        return $this;
    }

    public function getArticlePrice(): ?float
    {
        return $this->article_price;
    }

    public function setArticlePrice(float $article_price): self
    {
        $this->article_price = $article_price;

        return $this;
    }

    public function getArticleStock(): ?int
    {
        return $this->article_stock;
    }

    public function setArticleStock(int $article_stock): self
    {
        $this->article_stock = $article_stock;

        return $this;
    }

    public function getArticlePictureLink(): ?string
    {
        return $this->article_picture_link;
    }

    public function setArticlePictureLink(string $article_picture_link): self
    {
        $this->article_picture_link = $article_picture_link;

        return $this;
    }

    public function getArticleSlug(): ?string
    {
        return $this->article_slug;
    }

    public function setArticleSlug(?string $article_slug): self
    {
        $this->article_slug = $article_slug;

        return $this;
    }

    public function getArticleCreatedAt(): ?\DateTimeInterface
    {
        return $this->article_createdAt;
    }

    public function setArticleCreatedAt(\DateTimeInterface $article_createdAt): self
    {
        $this->article_createdAt = $article_createdAt;

        return $this;
    }

    public function getArticleUpdatedAt(): ?\DateTimeInterface
    {
        return $this->article_updatedAt;
    }

    public function setArticleUpdatedAt(?\DateTimeInterface $article_updatedAt): self
    {
        $this->article_updatedAt = $article_updatedAt;

        return $this;
    }
}
