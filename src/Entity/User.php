<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $adress;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    
    private $email;

    /**
     * @ORM\Column(type="json")
     * 
     * @OA\Property(type="array", @OA\Items(type="string"))
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

        /**
     * @ORM\Column(type="string", length=20)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user")
     * @Groups("readUser")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="user")
     * @Groups("readUser")
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     * @Groups("readUser")
     */
    private $comments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getUserLastname(): ?string
    {
        return $this->lastname;
    }

    public function setUserLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUserFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setUserFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getUserAdress(): ?string
    {
        return $this->adress;
    }

    public function setUserAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getUserBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setUserBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }


    public function getUserPhone(): ?string
    {
        return $this->phone;
    }

    public function setUserPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getUserCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setUserCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUserUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setOrderUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getOrderUser() === $this) {
                $order->setOrderUser(null);
            }
        }

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
            $favorite->setFavoriteUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getFavoriteUser() === $this) {
                $favorite->setFavoriteUser(null);
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
            $comment->setCommentUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCommentUser() === $this) {
                $comment->setCommentUser(null);
            }
        }

        return $this;
    }
    
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
