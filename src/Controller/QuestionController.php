<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        $people = [
            "prenom" => "Firas",
            "nom"    => "Amina"
        ];

        return $this->render(
            'question/homepage.html.twig',
            $people
        );
    }
    /**
     * @Route("/questions/{anything}")
     */
    public function show($anything)
    {
        return new Response(sprintf(
            'Future page to show the question "%s"!',
            $anything));
    }
}