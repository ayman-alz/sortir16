<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{
    #[Route('/annuler_sortie/{id}', name: 'app_annuler_sortie')]
    public function annulerSortir(SortieRepository       $sortieRepository, $id, EtatRepository $etatRepository,
                                  EntityManagerInterface $em): Response
    {
        $sortie = $sortieRepository->find($id);
        $etatAnnuler = $etatRepository->findByLibelle(Etat::ANNULE);

        if (($this->getUser() !== $sortie->getOrganisateur()) && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $sortie->setEtat($etatAnnuler);
        $em->persist($sortie);
        $em->flush();
        $this->addFlash('success', 'La sortie a été annulé');


        return $this->redirectToRoute('app_home');
    }

    #[Route('/suprimer-sortie/{id}', name: 'app_suprimer_sortie')]
    public function suprimerSortir(SortieRepository $sortieRepository, $id, EntityManagerInterface $em,): Response
    {

        $sortie = $sortieRepository->find($id);
        if (($this->getUser() !== $sortie->getOrganisateur()) && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $em->remove($sortie);
        $em->flush();
        $this->addFlash('success', 'La sortie a été supprimée');


        return $this->redirectToRoute('app_home');
    }
}
