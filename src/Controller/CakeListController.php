<?php

namespace App\Controller;

use App\Repository\CakeRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CakeListController extends AbstractController
{
    private $imageFolder = "images/produits/";

    /**
     * @Route("/produits/gateaux", name="showCakeList")
     */
    public function showProductList(CakeRepository $repo): Response
    {
       $data = $repo->findAll();

       return $this->render("product/cakeList.html.twig", [
           'cakeList' => $data,
           'imageFolder' => $this->imageFolder
       ]);
    }
}
