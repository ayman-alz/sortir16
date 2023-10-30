<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends AbstractController
{
    #[Route('/creation_sortie', name: 'app_creation_sortie')]
    public function index(): Response
    {
        return $this->render('creation_sortie/create_sortie.html.twig', [
            'controller_name' => 'CreationSortieController',
        ]);
    }
}
