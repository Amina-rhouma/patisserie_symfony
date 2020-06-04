<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\VerrineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $imageFolder = "images/produits/";

    /**
     * @Route("/produits/gateaux/{productId}", name="productGateau")
     */
    public function showProduct(ProductRepository $repo, $productId) {
        $product = $repo->findById($productId);

        return $this->render("product/product.html.twig", [
            'product' => $product,
            'imageFolder' => $this->imageFolder
        ]);
    }
    /**
     * @Route("/produits/verrines/{productId}", name="productVerrine")
     */
    public function showVerrineProduct(VerrineRepository $repo, $productId)
    {
        $verrine = $repo->findById($productId);

        return $this->render("product/product.html.twig", [
            'product' => $verrine,
            'imageFolder' => $this->imageFolder
        ]);
    }

}