<?php

namespace App\Controller;
use App\Entity\Verrine;
use App\Repository\VerrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductVerrineListController extends AbstractController
{
    private $imageFolder = "images/produits/";
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/produits/verrines", name="showVerrineList")
     */
    public function showVerrineList(VerrineRepository $repo): Response
    {
        // $v1 = new Verrine("tiramisu", "6", "dessert leger", "tiramisu.jpg");
        // $this->em->persist($v1);
        // $this->em->flush();

        $data = $repo->findAll();

        return $this->render("product/productVerrineList.html.twig", [
            'verrineList' => $data,
            'imageFolder' => $this->imageFolder
        ]);
    }

}