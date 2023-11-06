<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieFormType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierSortieController extends AbstractController
{
    #[Route('/modifier_sortie/{id}', name: 'app_modifier_sortie',requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    public function index(EntityManagerInterface $em,Sortie $sortie,  VilleRepository  $villeRepository,Request $request): Response
    {
        $villes = $villeRepository->findAll();

        $form_sortie = $this->createForm(SortieFormType::class,$sortie);
        $form_sortie->handleRequest($request);

        return $this->render('modifier_sortie/modifier_sortie.html.twig', [
            'sortie'=>$sortie,
            'form_sortie'=>$form_sortie,
            'cities' => $villes,

        ]);
    }
}
