<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * 
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
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $picture_link;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=VAT::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $vat;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Discount::class, inversedBy="articles")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $discount;

    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="article")
     * 
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     */
    private $comments;

    /**
     * @ORM\Column(type="float", nullable=true)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=Orderlist::class, mappedBy="article")
     * 
     */
    private $orderlists;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->orderlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleName(): ?string
    {
        return $this->name;
    }

    public function setArticleName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArticleDescription(): ?string
    {
        return $this->description;
    }

    public function setArticleDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArticlePrice(): ?float
    {
        return $this->price;
    }

    public function setArticlePrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getArticleStock(): ?int
    {
        return $this->stock;
    }

    public function setArticleStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getArticlePictureLink(): ?string
    {
        return $this->picture_link;
    }

    public function setArticlePictureLink(string $picture_link): self
    {
        $this->picture_link = $picture_link;

        return $this;
    }

    public function getArticleSlug(): ?string
    {
        return $this->slug;
    }

    public function setArticleSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getArticleCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setArticleCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getArticleUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setArticleUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getArticleVat(): ?VAT
    {
        return $this->vat;
    }

    public function setArticleVat(?VAT $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getArticleBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setArticleBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getArticleCategory(): ?Category
    {
        return $this->category;
    }

    public function setArticleCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getArticleDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setArticleDiscount(?Discount $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setFavoriteArticle($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getFavoriteArticle() === $this) {
                $favorite->setFavoriteArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCommentArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCommentArticle() === $this) {
                $comment->setCommentArticle(null);
            }
        }

        return $this;
    }

    public function getArticleRating(): ?float
    {
        return $this->rating;
    }

    public function setArticleRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, Orderlist>
     */
    public function getOrderlists(): Collection
    {
        return $this->orderlists;
    }

    public function addOrderlist(Orderlist $orderlist): self
    {
        if (!$this->orderlists->contains($orderlist)) {
            $this->orderlists[] = $orderlist;
            $orderlist->setOrderlistArticle($this);
        }

        return $this;
    }

    public function removeOrderlist(Orderlist $orderlist): self
    {
        if ($this->orderlists->removeElement($orderlist)) {
            // set the owning side to null (unless already changed)
            if ($orderlist->getOrderlistArticle() === $this) {
                $orderlist->setOrderlistArticle(null);
            }
        }

        return $this;
    }
}
