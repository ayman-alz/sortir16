<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{
    #[Route('/annuler_sortie/{id}', name: 'app_annuler_sortie')]
    public function delete(SortieRepository $sortieRepository,$id, EntityManagerInterface $em, ): Response
    {
        $sortie= $sortieRepository->find($id);
        $em->remove($sortie);
        $em->flush();
        $this->addFlash('success', 'La sortie a été supprimée');


        return $this->redirectToRoute('app_home');
    }
}