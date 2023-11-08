<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{
    #[Route('/annuler_sortie/{id}', name: 'app_annuler_sortie')]
    public function annuleSortie(SortieRepository $sortieRepository,$id, EtatRepository $repository,EntityManagerInterface $em, ): Response
    {

        $etat = $repository -> findByLibelle(Etat::ANNULE);
        $sortie= $sortieRepository->find($id);
        if ( $this->getUser()  !== $sortie->getOrganisateur())
        {
            throw $this->createAccessDeniedException();
        }
        $sortie->setEtat($etat);
        $em->persist($sortie);
        $em->flush();
        $this->addFlash('success', 'La sortie a été Annuler');

        return $this->redirectToRoute('app_home');
    }
    #[Route('/suprimer_sortie/{id}', name: 'app_suprimer_sortie')]
    public function deleteSortie(SortieRepository $sortieRepository,$id, EntityManagerInterface $em, ): Response
    {
        $sortie= $sortieRepository->find($id);
        if ( $this->getUser()  !== $sortie->getOrganisateur())
        {
            throw $this->createAccessDeniedException();
        }
        $em->remove($sortie);
        $em->flush();
        $this->addFlash('success', 'La sortie a été supprimée');


        return $this->redirectToRoute('app_home');
    }
}