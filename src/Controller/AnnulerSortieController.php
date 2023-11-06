<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{
    #[Route('/annuler_sortie/{id}', name: 'app_annuler_sortie')]
    public function delete(Sortie $sortie, EntityManagerInterface $em, Request $request): Response
    {

    $em->remove($sortie);
    $em->flush();
    $this->addFlash('success', 'La sortie a été supprimée');


        return $this->render('annuler_sortie/annuler_sortie.html.twig', [
            'controller_name' => 'AnnulerSortieController',
        ]);
    }
}
