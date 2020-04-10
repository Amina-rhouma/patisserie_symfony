<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController {
    /**
     * @Route("/signin")
     */
    public function signin()
    {
        return new Response("ajouter fonction sighin");
    }
    /**
     * @Route("/login")
     */
    public function login()
    {
        return new Response("ajouter fonction login");
    }
}