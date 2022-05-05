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
    private $category_name;

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
    private $category_picture_link;

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
    private $category_slug;

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
    private $category_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_category")
     * @Groups("read_category")
     * @Groups("add_category")
     * @Groups("read_category_article")
     */
    private $category_updatedAt;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    private $category_display_order;

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

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function getCategoryPictureLink(): ?string
    {
        return $this->category_picture_link;
    }

    public function setCategoryPictureLink(string $category_picture_link): self
    {
        $this->category_picture_link = $category_picture_link;

        return $this;
    }

    public function getCategorySlug(): ?string
    {
        return $this->category_slug;
    }

    public function setCategorySlug(?string $category_slug): self
    {
        $this->category_slug = $category_slug;

        return $this;
    }

    public function getCategoryCreatedAt(): ?\DateTimeInterface
    {
        return $this->category_createdAt;
    }

    public function setCategoryCreatedAt(\DateTimeInterface $category_createdAt): self
    {
        $this->category_createdAt = $category_createdAt;

        return $this;
    }

    public function getCategoryUpdatedAt(): ?\DateTimeInterface
    {
        return $this->category_updatedAt;
    }

    public function setCategoryUpdatedAt(?\DateTimeInterface $category_updatedAt): self
    {
        $this->category_updatedAt = $category_updatedAt;

        return $this;
    }

    public function getCategoryDisplayOrder(): ?int
    {
        return $this->category_display_order;
    }

    public function setCategoryDisplayOrder(int $category_display_order): self
    {
        $this->category_display_order = $category_display_order;

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
            $article->setArticleCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticleCategory() === $this) {
                $article->setArticleCategory(null);
            }
        }

        return $this;
    }
}
