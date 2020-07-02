<?php

namespace App\Entity;

use App\Repository\VerrineLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VerrineLikeRepository::class)
 * @ORM\Table(name="verrine_like")
 */
class VerrineLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Verrine::class, inversedBy="likes")
     */
    private $verrine;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="verrineLikes")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVerrine(): ?Verrine
    {
        return $this->verrine;
    }

    public function setVerrine(?Verrine $verrine): self
    {
        $this->verrine = $verrine;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
