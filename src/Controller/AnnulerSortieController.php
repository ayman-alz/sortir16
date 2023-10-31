<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{
    #[Route('/annuler_sortie', name: 'app_annuler_sortie')]
    public function index(): Response
    {
        return $this->render('annuler_sortie/annuler_sortie.html.twig', [
            'controller_name' => 'AnnulerSortieController',
        ]);
    }
}
