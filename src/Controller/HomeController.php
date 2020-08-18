<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $imageFolder = "images/slider/";
    private $imageProduit = "images/produits/";
    private $imageInsta = "images/insta/";




    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function index()
    {
        return $this->render(
            'home.html.twig',
            [
                'imageFolder' => $this->imageFolder,
                'imageInsta' => $this->imageInsta,
                'imageProduit' => $this->imageProduit,
            ]
        );
    }
}
