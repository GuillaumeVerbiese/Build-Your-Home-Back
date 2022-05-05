<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_brand")
     * @Groups("read_brand")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups("browse_brand")
     * @Groups("read_brand")
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $brand_name;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups("browse_brand")
     * @Groups("read_brand")
     */
    private $brand_slug;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("browse_brand")
     * @Groups("read_brand")
     */
    private $brand_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("browse_brand")
     * @Groups("read_brand")
     */
    private $brand_updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="brand")
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

    public function getBrandName(): ?string
    {
        return $this->brand_name;
    }

    public function setBrandName(string $brand_name): self
    {
        $this->brand_name = $brand_name;

        return $this;
    }

    public function getBrandSlug(): ?string
    {
        return $this->brand_slug;
    }

    public function setBrandSlug(string $brand_slug): self
    {
        $this->brand_slug = $brand_slug;

        return $this;
    }

    public function getBrandCreatedAt(): ?\DateTimeInterface
    {
        return $this->brand_createdAt;
    }

    public function setBrandCreatedAt(\DateTimeInterface $brand_createdAt): self
    {
        $this->brand_createdAt = $brand_createdAt;

        return $this;
    }

    public function getBrandUpdatedAt(): ?\DateTimeInterface
    {
        return $this->brand_updatedAt;
    }

    public function setBrandUpdatedAt(?\DateTimeInterface $brand_updatedAt): self
    {
        $this->brand_updatedAt = $brand_updatedAt;

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
            $article->setArticleBrand($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticleBrand() === $this) {
                $article->setArticleBrand(null);
            }
        }

        return $this;
    }
}
