<?php

namespace App\Entity;

use App\Repository\CakeLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CakeLikeRepository::class)
 * @ORM\Table(name="cake_like")
 */
class CakeLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cake::class, inversedBy="likes")
     */
    private $cake;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
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

    public function getCake(): ?Cake
    {
        return $this->cake;
    }

    public function setCake(?Cake $cake): self
    {
        $this->cake = $cake;

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
