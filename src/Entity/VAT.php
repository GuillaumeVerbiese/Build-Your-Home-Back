<?php

namespace App\Entity;

use App\Repository\VATRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VATRepository::class)
 */
class VAT
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_vat")
     * @Groups("read_vat")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_vat")
     * @Groups("read_vat")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_vat")
     * @Groups("read_vat")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_vat")
     * @Groups("read_vat")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_vat")
     * @Groups("read_vat")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="vat")
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

    public function getVatName(): ?string
    {
        return $this->name;
    }

    public function setVatName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVatRate(): ?float
    {
        return $this->rate;
    }

    public function setVatRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getVatCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setVatCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getVatUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setVatUpdatedAt(?\DateTimeInterface $updatedAt): self
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
            $article->setArticleVat($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticleVat() === $this) {
                $article->setArticleVat(null);
            }
        }

        return $this;
    }
}
