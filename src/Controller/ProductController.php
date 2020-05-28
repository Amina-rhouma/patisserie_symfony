<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/produits/{productId}")
     */
    public function showProduct($productId) {
        $imagesFolder = "images/produits/";

        $productData = [
            "title"       => "Gateau pistache (taille M)",
            "description" => "Ce gâteau majestueux à la pistache doit être fait avec des noix non salées. Malheureusement, elles ne se vendent pas partout. On les trouve souvent dans les magasins d'aliments naturels. À défaut, achetez quand même des pistaches écalées salées. Il suffira de les rincer sous l'eau puis de les faire sécher au four pendant quelques minutes à 180 °C (350 °F).",
            "price"       => 60,
            "imagePath"   => $imagesFolder . "gateau-pistache.jpg"
        ];

        return $this->render("product/product.html.twig", $productData);
    }

}