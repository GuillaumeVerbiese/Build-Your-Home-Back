<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_category")
     * @Groups("read_category")
     * @Groups("add_category")
     * @Groups("read_category_article")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("browse_category")
     * @Groups("read_category")
     * @Groups("add_category")
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups("browse_category")
     * @Groups("read_category")
     * @Groups("add_category")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * 
     * @Groups("browse_category")
     * @Groups("read_category")
     * @Groups("add_category")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_category")
     * @Groups("read_category")
     * @Groups("add_category")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_category")
     * @Groups("read_category")
     * @Groups("add_category")
     * @Groups("read_category_article")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    private $display_order;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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

    public function getDisplayOrder(): ?int
    {
        return $this->display_order;
    }

    public function setDisplayOrder(int $display_order): self
    {
        $this->display_order = $display_order;

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
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }
}
