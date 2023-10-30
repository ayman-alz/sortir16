<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonProfilController extends AbstractController
{
    #[Route('/mon_profil', name: 'app_mon_profil')]
    public function index(): Response
    {
        return $this->render('mon_profil/mon_profil.html.twig', [
            'controller_name' => 'MonProfilController',
        ]);
    }
}
