<?php


namespace App\Controller;


use App\Repository\CakeRepository;
use App\Repository\VerrineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    const CART_NAME = "panier";
    const CART_TYPE_NAME = "type";
    const CAKE = "cake";
    const VERRINE = "verrine";
    const EMPTY_CART = [
        CartController::CAKE => [],
        CartController::VERRINE => []
    ];

    /**
     * @Route("/panier", name="app_panier")
     */
    public function showPanier(SessionInterface $session, CakeRepository $cakeRepository, VerrineRepository $verrineRepository) {

        $panier = $session->get(
            self::CART_NAME,
            self::EMPTY_CART
        );

        $panierWithData = [];
        $panierCakeWithData = [];
        $panierVerrineWithData = [];

        foreach ($panier[self::CAKE] as $id => $quantity) {
            $cakeData = $cakeRepository->find($id);
            $panierCakeWithData[] = [
                "product" => $cakeData,
                "quantity" => $quantity
            ];
        }

        foreach ($panier[self::VERRINE] as $id => $quantity) {
            $verrineData = $verrineRepository->find($id);
            $panierVerrineWithData[] = [
                "product" => $verrineData,
                "quantity" => $quantity

            ];
        }

        $panierWithData[self::CAKE] = $panierCakeWithData;
        $panierWithData[self::VERRINE] = $panierVerrineWithData;

        dd($panierWithData);

        return $this->render("cart/panier.html.twig", ["panier" => $panierWithData]);
    }

    /**
     * @Route("/panier/add/{id}", name="app_add_panier")
     */
    public function add(int $id, Request $request, SessionInterface $session) {
        $type = $request->query->get(self::CART_TYPE_NAME);

        $panier = $session->get(
            self::CART_NAME,
            self::EMPTY_CART
        );

        switch($type) {
            case self::CAKE:
                $this->addToCartByType($panier, $id, self::CAKE, $session);
                break;
            case self::VERRINE:
                $this->addToCartByType($panier, $id, self::VERRINE, $session);
                break;
            default:
                dd("erreur");
        }

        return $this->redirectToRoute("accueil");
    }

    private function addToCartByType($panier, int $id, string $type, SessionInterface $session) {
        $typePanier = $panier[$type];

        if (empty($typePanier[$id])) {
            $typePanier[$id] = 1;
        } else {
            $typePanier[$id]++;
        }

        $panier[$type] = $typePanier;
        $session->set(self::CART_NAME, $panier);
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