<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response("Homepage");
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