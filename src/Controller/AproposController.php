<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AproposController extends AbstractController
{
    private $imageFolder = "images/aboutus/";


    /**
     * @Route("/apropos", name="app_apropos", methods={"GET"})
     */
    public function index()
    {
        return $this->render('apropos.html.twig', ['imageFolder' => $this->imageFolder] );
    }
}