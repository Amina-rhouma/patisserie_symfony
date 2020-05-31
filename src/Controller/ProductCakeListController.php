<?php

namespace App\Controller;

use App\Entity\Product;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductCakeListController extends AbstractController
{
    /**
     * @Route("/produits/gateaux")
     */
   public function showProductList()
   {
       $cakeFolder = "images/produits/";

       $p1 = new Product("Gateau pistache", 60, "description pistache", $cakeFolder . "gateau-pistache.jpg");
       $p2 = new Product("Gateau fraise", 50, "description fraise", $cakeFolder . "gateau-fraise.jpg");
       $p3 = new Product("gateau chocolat", 55, "description chhocolat", $cakeFolder. "gateau-chocolat.jpg");
       $p4 = new Product("gateau vanille", 65, "description vanille", $cakeFolder. "gateau-vanille.jpg");
       $p5 = new Product("gateau citron", 40, "description citron", $cakeFolder. "gateau-citron.jpg");



       $data = [
           "productList" => [$p1, $p2, $p3, $p4, $p5]
       ];
       return $this->render("product/productCakeList.html.twig", $data);
   }

}
