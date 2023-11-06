<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }



    #[Route('/filter', name: 'app_filter')]
    public function filter(FilterReposotory $reposotory)
    {

        $filters = $reposotory -> findSearch();
        return $this->render('home/home.html.twig', [
            'filters' => '$filters',
        ]);
    }
}
