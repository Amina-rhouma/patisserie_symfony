<?php

namespace App\Controller;

use App\Entity\Verrine;
use App\Repository\VerrineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VerrineController extends AbstractController
{
    private $imageFolder = "images/produits/";

    /**
     * @Route("/produits/verrines/{id}", name="productVerrine")
     */
    public function showVerrineProduct(VerrineRepository $repo, int $id)
    {
        $verrine = $repo->find($id);
        if (!$verrine) {
            throw $this->createNotFoundException('Produit '. $id. ' not found');
        }

        return $this->render("product/product.html.twig", [
            'product' => $verrine,
            'imageFolder' => $this->imageFolder,
            'type' => Verrine::TYPE,
            'likes' => count($verrine->getLikes())
        ]);
    }

}