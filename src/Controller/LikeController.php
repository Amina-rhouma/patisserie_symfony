<?php

namespace App\Controller;

use App\Service\LikeService;
use App\Security\LikeAuthorization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController {

    /**
     * @Route("/like", name="app_like", methods="post")
     */
    public function like(LikeService $likeService, Request $request) {
        $this->denyAccessUnlessGranted(LikeAuthorization::LIKE_PRODUCT);

        $data = json_decode($request->getContent(), true);
        $productId = $data['id_product'];
        $type = $data['type_product'];
        $rating = $data['rating'];

        $newAvgRating = $likeService->like($productId, $type, $rating);

        if ($newAvgRating >= 0) {
            return $this->json('{ "message": "ok", "newRating": "' . $newAvgRating . '" }', 200);
        } else {
            return $this->json('{ "message": "error" }', 500);
        }
    }

    /**
     * @Route("/dislike", name="app_dislike", methods="post")
     */
    public function dislike(LikeService $likeService, Request $request) {
        $this->denyAccessUnlessGranted(LikeAuthorization::LIKE_PRODUCT);

        $data = json_decode($request->getContent(), true);
        $productId = $data['id_product'];
        $type = $data['type_product'];

        $dislikePersisted = $likeService->dislike($productId, $type);

        if ($dislikePersisted) {
            return $this->json("{ message: 'disliked' }", 200);
        } else {
            return $this->json("{ message: 'error' }", 500);
        }

    }
}
