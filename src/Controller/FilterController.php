<?php

namespace App\Controller;

use App\Form\Model\SortieFiltre;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    #[Route('/filter', name: 'app_filter' , methods: ['GET' , 'POST'])]
    public function list(Request $request,  FilterReposotory $reposotory)
    {

        $sortiefiltre = [];
        $sortiefiltre = new SortieFiltre();
        $form = $this->createForm(SearchFormType::class, $sortiefiltre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() )
        {
            $filters = $reposotory -> findSearch();
        }




        return $this->render('home/home.html.twig', [
            'filters' => '$filters',
        ]);
    }
}
