<?php

namespace App\Controller;

use App\Security\CartAuthorization;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $imageFolder = "images/produits/";

    public const CART_TYPE_NAME = "type";

    /**
     * @Route("/panier", name="app_panier")
     */
    public function showPanier(CartService $cartService) {
        $this->denyAccessUnlessGranted(CartAuthorization::VIEW_CART);

        $panierWithData = $cartService->getPanierWithData();
        $total = $cartService->getTotal($panierWithData);

        return $this->render("cart/panier.html.twig", [
            "panier" => $panierWithData,
            "total" => $total,
            "imageFolder" => $this->imageFolder
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="app_add_panier")
     */
    public function add(int $id, Request $request, CartService $cartService) {
        $this->denyAccessUnlessGranted(CartAuthorization::VIEW_CART);

        $type = $request->query->get(self::CART_TYPE_NAME);
        $cartService->addToCart($id, $type);
        return $this->redirectToRoute("accueil");
    }


    /**
     * @ROUTE("panier/supprimer/{id}", name="cart_delete")
     */
    public function delete($id, Request $request, CartService $cartService) {
        $type = $request->query->get(self::CART_TYPE_NAME);

        $cartService->deleteProductFromCart($id, $type);

        return $this->redirectToRoute("app_panier");
    }
}

/*

panier = [
    "cake" => [
        id => quantity,
        id => quantity,
        id => quantity,
    ],
    "verrine" => [
        id => quantity,
        id => quantity,
        id => quantity,
    ]
]

 */