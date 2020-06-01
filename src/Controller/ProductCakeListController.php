<?php

namespace App\Controller;

use App\Entity\Product;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductCakeListController extends AbstractController
{
    private $cakeImagesFolder = "images/produits/";
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em= $em;
    }

    /**
     * @Route("/produits/gateaux", name="showCakeList")
     */
   public function showProductList()
   {
       $repo=$this->em->getRepository(Product::class);
       $data= $repo->findAll();

       return $this->render("product/productCakeList.html.twig", [
           'cakeList' => $data,
           'cakeImagesFolder' => $this->cakeImagesFolder
       ]);
   }

}
