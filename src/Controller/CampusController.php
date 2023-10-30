<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin')]

class CampusController extends AbstractController
{
    #[Route('/campus', name: 'app_campus')]
    public function index(): Response
    {
        return $this->render('campus/campus_gerer.html.twig', [
            'controller_name' => 'CampusController',
        ]);
    }
}
