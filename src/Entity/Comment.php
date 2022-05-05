<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("readUser")
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
    private $comment_created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $comment_updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment_article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
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

    public function getCommentCreatedAt(): ?\DateTimeInterface
    {
        return $this->comment_created_at;
    }

    public function setCommentCreatedAt(\DateTimeInterface $comment_created_at): self
    {
        $this->comment_created_at = $comment_created_at;

        return $this;
    }

    public function getCommentUpdatedAt(): ?\DateTimeInterface
    {
        return $this->comment_updated_at;
    }

    public function setCommentUpdatedAt(?\DateTimeInterface $comment_updated_at): self
    {
        $this->comment_updated_at = $comment_updated_at;

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
