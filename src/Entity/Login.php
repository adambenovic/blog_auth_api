<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoginRepository")
 */
class Login
{
    /**
     * Login constructor.
     * @param Api_User $user
     * @throws \Exception
     */
    public function __construct(Api_User $user)
    {
        $this->user = $user;
        $this->last_login = new \DateTime('now');
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Api_User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Api_User", inversedBy="last_login")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_login;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Api_User
    {
        return $this->user;
    }

    public function setUser(Api_User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }
}
