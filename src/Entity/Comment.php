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
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
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
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentBody(): ?string
    {
        return $this->body;
    }

    public function setCommentBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCommentRating(): ?int
    {
        return $this->rating;
    }

    public function setCommentRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCommentCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCommentCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCommentUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setCommentUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCommentArticle(): ?Article
    {
        return $this->article;
    }

    public function setCommentArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCommentUser(): ?User
    {
        return $this->user;
    }

    public function setCommentUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
