<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $user_lastname;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $user_firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_adress;

    /**
     * @ORM\Column(type="datetime")
     */
    private $user_birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_password;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $user_role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_mail;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $user_phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $user_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $user_updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLastname(): ?string
    {
        return $this->user_lastname;
    }

    public function setUserLastname(string $user_lastname): self
    {
        $this->user_lastname = $user_lastname;

        return $this;
    }

    public function getUserFirstname(): ?string
    {
        return $this->user_firstname;
    }

    public function setUserFirstname(string $user_firstname): self
    {
        $this->user_firstname = $user_firstname;

        return $this;
    }

    public function getUserAdress(): ?string
    {
        return $this->user_adress;
    }

    public function setUserAdress(string $user_adress): self
    {
        $this->user_adress = $user_adress;

        return $this;
    }

    public function getUserBirthdate(): ?\DateTimeInterface
    {
        return $this->user_birthdate;
    }

    public function setUserBirthdate(\DateTimeInterface $user_birthdate): self
    {
        $this->user_birthdate = $user_birthdate;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->user_password;
    }

    public function setUserPassword(string $user_password): self
    {
        $this->user_password = $user_password;

        return $this;
    }

    public function getUserRole(): ?string
    {
        return $this->user_role;
    }

    public function setUserRole(string $user_role): self
    {
        $this->user_role = $user_role;

        return $this;
    }

    public function getUserMail(): ?string
    {
        return $this->user_mail;
    }

    public function setUserMail(string $user_mail): self
    {
        $this->user_mail = $user_mail;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->user_phone;
    }

    public function setUserPhone(string $user_phone): self
    {
        $this->user_phone = $user_phone;

        return $this;
    }

    public function getUserCreatedAt(): ?\DateTimeInterface
    {
        return $this->user_createdAt;
    }

    public function setUserCreatedAt(\DateTimeInterface $user_createdAt): self
    {
        $this->user_createdAt = $user_createdAt;

        return $this;
    }

    public function getUserUpdatedAt(): ?\DateTimeInterface
    {
        return $this->user_updatedAt;
    }

    public function setUserUpdatedAt(?\DateTimeInterface $user_updatedAt): self
    {
        $this->user_updatedAt = $user_updatedAt;

        return $this;
    }
}
