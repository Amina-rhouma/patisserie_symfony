<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
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
     * @Route("/questions/{question_name}", name="app_show_question")
     */
    public function show($question_name)
    {
        return new Response(sprintf(
            'Future page to show the question "%s"!',
            $question_name));
    }
}