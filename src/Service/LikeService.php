<?php

namespace App\Service;

use App\Entity\Cake;
use App\Entity\CakeLike;
use App\Entity\Verrine;
use App\Entity\VerrineLike;
use App\Repository\CakeLikeRepository;
use App\Repository\CakeRepository;
use App\Repository\VerrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Security;

class LikeService {

    private $security;
    private $em;
    private $cakeRepository;
    private $verrineRepository;
    private $cakeLikeRepository;

    public function __construct(Security $security, EntityManagerInterface $em, CakeRepository $cakeRepository, VerrineRepository $verrineRepository, CakeLikeRepository $cakeLikeRepository)
    {
        $this->security = $security;
        $this->em = $em;
        $this->cakeRepository = $cakeRepository;
        $this->verrineRepository = $verrineRepository;
        $this->cakeLikeRepository = $cakeLikeRepository;

    }

    public function like(int $productId, string $type, int $rating) {
        if ($type === Cake::TYPE) {
            return $this->likeCake($productId, $rating);
        } else if ($type === Verrine::TYPE) {
            return $this->likeVerrine($productId, $rating);
        }
        return -1;
    }

    private function likeCake(int $cakeId, int $rating) {
        try {
            $user = $this->security->getUser();
            $cake = $this->cakeRepository->find($cakeId);
            $allPreviousLikes = $cake->getLikes()->getValues(); // 50

            $allUsersThatLikedThisCake = array_column($allPreviousLikes, "user");

            if (in_array($user, $allUsersThatLikedThisCake)) {
                foreach ($allPreviousLikes as $cakeLike) {
                    if ($cakeLike->getUser() === $user) {
                        $cakeLike->setRating($rating);
                        $this->em->persist($cakeLike);
                        $this->em->flush();
                        break;
                    }
                }
            } else {
                $cakeLike = new CakeLike();
                $cakeLike->setCake($cake);
                $cakeLike->setUser($user);
                $cakeLike->setRating($rating);

                $this->em->persist($cakeLike);
                $this->em->flush();
            }

            $cake = $this->cakeRepository->find($cakeId);
            $allNewLikes = $cake->getLikes()->getValues();
            $newAvgRatings = $this->calculateAvgRatings($allNewLikes);

            return $newAvgRatings;
        } catch (Exception $e) {
            return -1;
        }
    }

    private function likeVerrine(int $verrineId, int $rating) {
        try {
            $user = $this->security->getUser();
            $verrine = $this->verrineRepository->find($verrineId);
            $allPreviousLikes = $verrine->getLikes()->getValues();

            $allUsersThatLikedThisVerrine = array_column($allPreviousLikes, "user");

            if (in_array($user, $allUsersThatLikedThisVerrine)) {
                foreach ($allPreviousLikes as $verrineLike) {
                    if ($verrineLike->getUser() === $user) {
                        $verrineLike->setRating($rating);
                        $this->em->persist($verrineLike);
                        $this->em->flush();
                        break;
                    }
                }
            } else {
                $verrineLike = new VerrineLike();
                $verrineLike->setVerrine($verrine);
                $verrineLike->setUser($user);
                $verrineLike->setRating($rating);

                $this->em->persist($verrineLike);
                $this->em->flush();

            }

            $verrine = $this->verrineRepository->find($verrineId);
            $allNewLikes = $verrine->getLikes()->getValues();
            $newAvgRatings = $this->calculateAvgRatings($allNewLikes);

            return $newAvgRatings;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function dislike(int $productId, string $type) {
        if ($type === Cake::TYPE) {
            return $this->dislikeCake($productId);
        } else if ($type === Verrine::TYPE) {
            return $this->dislikeVerrine($productId);
        }
        return false;
    }

    private function dislikeCake(int $cakeId) {
        try {
            $user = $this->security->getUser();
            $cake = $this->cakeRepository->find($cakeId);
            $allPreviousLikes = $cake->getLikes()->getValues();

            foreach ($allPreviousLikes as $like) {
                if ($like->getUser()->getId() === $user->getId()) {
                    $this->em->remove($like);
                    $this->em->flush();
                    break;
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function dislikeVerrine(int $verrineId) {
        try {
            $user = $this->security->getUser();
            $verrine = $this->verrineRepository->find($verrineId);
            $allPreviousLikes = $verrine->getLikes()->getValues();

            foreach ($allPreviousLikes as $like) {
                if ($like->getUser()->getId() === $user->getId()) {
                    $this->em->remove($like);
                    $this->em->flush();
                    break;
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function calculateAvgRatings($likes) {
        $likesNumber = count($likes);

        if (isset($likes) && $likesNumber > 0) {
            $sumRatings = 0;
            foreach ($likes as $like) {
                $sumRatings = $sumRatings + $like->getRating();
            }
            $avgRatings = $sumRatings / $likesNumber;
            return $avgRatings;
        } else {
            return 0;
        }
    }
}