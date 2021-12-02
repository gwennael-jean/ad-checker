<?php

namespace App\Controller\Checker\Chocobonplan;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PS5Controller extends AbstractController
{
    #[Route('/checker/chocobonplan/ps5', name: 'checker_chocobonplan_ps5')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Chocobonplan/PS5Controller.php',
        ]);
    }
}
