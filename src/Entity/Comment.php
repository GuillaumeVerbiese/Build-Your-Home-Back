<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment_body;

    /**
     * @ORM\Column(type="integer")
     */
    private $comment_rating;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment_article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentBody(): ?string
    {
        return $this->comment_body;
    }

    public function setCommentBody(string $comment_body): self
    {
        $this->comment_body = $comment_body;

        return $this;
    }

    public function getCommentRating(): ?int
    {
        return $this->comment_rating;
    }

    public function setCommentRating(int $comment_rating): self
    {
        $this->comment_rating = $comment_rating;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCommentArticle(): ?Article
    {
        return $this->comment_article;
    }

    public function setCommentArticle(?Article $comment_article): self
    {
        $this->comment_article = $comment_article;

        return $this;
    }

    public function getCommentUser(): ?User
    {
        return $this->comment_user;
    }

    public function setCommentUser(?User $comment_user): self
    {
        $this->comment_user = $comment_user;

        return $this;
    }
}
