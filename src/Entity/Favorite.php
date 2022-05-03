<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavoriteRepository::class)
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favorites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $favorite_user;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="favorites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $favorite_article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFavoriteUser(): ?User
    {
        return $this->favorite_user;
    }

    public function setFavoriteUser(?User $favorite_user): self
    {
        $this->favorite_user = $favorite_user;

        return $this;
    }

    public function getFavoriteArticle(): ?Article
    {
        return $this->favorite_article;
    }

    public function setFavoriteArticle(?Article $favorite_article): self
    {
        $this->favorite_article = $favorite_article;

        return $this;
    }
}
