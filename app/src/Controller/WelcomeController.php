<?php
// src/Controller/WelcomeController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    /**
     * Renders the welcome page.
     *
     * This method is responsible for rendering the welcome page, which uses the
     * base template (`base.html.twig`). The route is mapped to the root URL (`/`).
     *
     * @return Response The rendered view response.
     */
    #[Route('/')]
    public function number(): Response
    {
        // Render the base.html.twig template and return the Response
        return $this->render('base.html.twig');
    }
}
