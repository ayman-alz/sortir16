<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierSortieController extends AbstractController
{
    #[Route('/modifier_sortie', name: 'app_modifier_sortie')]
    public function index(): Response
    {
        return $this->render('modifier_sortie/modifier_sortie.html.twig', [
            'controller_name' => 'ModifierSortieController',
        ]);
    }
}
