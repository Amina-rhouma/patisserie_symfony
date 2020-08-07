<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Entity\Verrine;
use App\Repository\CakeRepository;
use App\Repository\VerrineRepository;
use App\Security\ProductAuthorization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {
    private $imageFolder = "images/produits/";

    /**
    * @Route("/admin", name="admin")
    */
    public function showForAdmin(VerrineRepository $verrineRepository, CakeRepository $cakeRepository) {
        $this->denyAccessUnlessGranted(ProductAuthorization::ADD_PRODUCT);

        $verrineList = $verrineRepository->findAll();
        $gateauxList = $cakeRepository->findAll();

        return $this->render("user/admin.html.twig", [
            'verrineList' => $verrineList,
            'gateauList'  => $gateauxList,
            'imageFolder' => $this->imageFolder,
            'cakeType' => Cake::TYPE,
            'verrineType' => Verrine::TYPE
        ]);
    }
}