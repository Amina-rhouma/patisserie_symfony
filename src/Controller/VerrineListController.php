<?php

namespace App\Controller;
use App\Repository\VerrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerrineListController extends AbstractController
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
       // $v2 = new Verrine("Bouza", "4", "Une délicieuse crème faite à base de noisettes, ", "bouza.jpg");
        //$this->em->persist($v2);
       // $this->em->flush();

        $data = $repo->findAll();

        return $this->render("product/verrineList.html.twig", [
            'verrineList' => $data,
            'imageFolder' => $this->imageFolder
        ]);
    }

}