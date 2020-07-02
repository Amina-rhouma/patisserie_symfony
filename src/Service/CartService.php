<?php

namespace App\Service;

use App\Entity\Cake;
use App\Entity\Verrine;
use App\Repository\CakeRepository;
use App\Repository\VerrineRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    public const CART_NAME = "panier";
    public const EMPTY_CART = [
        Cake::TYPE => [],
        Verrine::TYPE => []
    ];

    protected $session;
    protected $cakeRepository;
    protected $verrineRepository;


    public function __construct(SessionInterface $session, CakeRepository $cakeRepository, VerrineRepository $verrineRepository)
    {
        $this->session = $session;
        $this->cakeRepository = $cakeRepository;
        $this->verrineRepository = $verrineRepository;
    }

    private function getPanier() {
        return $this->session->get(
            self::CART_NAME,
            self::EMPTY_CART
        );
    }

    public function addToCart(int $id, string $type) {

        $panier = $this->getPanier();

        switch($type) {
            case Cake::TYPE:
                $this->addToCartByType($panier, $id, Cake::TYPE);
                break;
            case Verrine::TYPE:
                $this->addToCartByType($panier, $id, Verrine::TYPE);
                break;
            default:
                dd("erreur");
        }
    }

    private function addToCartByType($panier, int $id, string $type) {
        $typePanier = $panier[$type];

        if (empty($typePanier[$id])) {
            $typePanier[$id] = 1;
        } else {
            $typePanier[$id]++;
        }

        $panier[$type] = $typePanier;
        $this->session->set(self::CART_NAME, $panier);
    }

    public function deleteProductFromCart(int $id, string $type)
    {
        if ($type === Cake::TYPE || $type === Verrine::TYPE) {
            $panier = $this->getPanier();

            if (!empty($panier[$type][$id])) {
                unset($panier[$type][$id]);
                $this->session->set(self::CART_NAME, $panier);
            }

        } else {
            dd("erreur");
        }
    }

    public function getTotal($panierWithData)
    {
        $total = 0;

        $panierCakeWithData = $panierWithData[Cake::TYPE];
        $panierVerrineWithData = $panierWithData[Verrine::TYPE];

        foreach ($panierCakeWithData as $item) {
            $total += $item["product"]->getPrice() * $item["quantity"];
        }

        foreach ($panierVerrineWithData as $item) {
            $total += $item["product"]->getPrice() * $item["quantity"];
        }

        return $total;
    }

    public function getPanierWithData()
    {
        $panier = $this->getPanier();

        $panierWithData = [];
        $panierCakeWithData = [];
        $panierVerrineWithData = [];

        foreach ($panier[Cake::TYPE] as $id => $quantity) {
            $cakeData = $this->cakeRepository->find($id);
            $panierCakeWithData[] = [
                "product" => $cakeData,
                "quantity" => $quantity
            ];
        }

        foreach ($panier[Verrine::TYPE] as $id => $quantity) {
            $verrineData = $this->verrineRepository->find($id);
            $panierVerrineWithData[] = [
                "product" => $verrineData,
                "quantity" => $quantity

            ];
        }

        $panierWithData[Cake::TYPE] = $panierCakeWithData;
        $panierWithData[Verrine::TYPE] = $panierVerrineWithData;

        return $panierWithData;
    }
}