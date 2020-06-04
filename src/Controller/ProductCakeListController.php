<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductCakeListController extends AbstractController
{
    private $imageFolder = "images/produits/";

    /**
     * @Route("/produits/gateaux", name="showCakeList")
     */
   public function showProductList(ProductRepository $repo): Response
   {
       $data = $repo->findAll();

       return $this->render("product/productCakeList.html.twig", [
           'cakeList' => $data,
           'imageFolder' => $this->imageFolder
       ]);
   }

}
