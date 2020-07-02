<?php

namespace App\Entity;

use App\Repository\CakeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CakeRepository::class)
 * @ORM\Table(name="cake")
 */
class Cake
{

    public const TYPE = "CAKE";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=CakeLike::class, mappedBy="cake")
     */
    private $likes;

    public function __construct(string $title, float $price, string $description, string $image) {
        $this->setTitle($title);
        $this->setPrice($price);
        $this->setDescription($description);
        $this->setImage($image);
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|CakeLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(CakeLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setCake($this);
        }

        return $this;
    }

    public function removeLike(CakeLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getCake() === $this) {
                $like->setCake(null);
            }
        }

        return $this;
    }

    /**
     * permet de savoir si cake est liké par un utilisateur
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user): bool {
        foreach ($this->likes as $like) {
            if($like->getUser() === $user) return true;
        }
        return false;
    }
}
