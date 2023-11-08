<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\SortieModifierType;
use App\Repository\EtatRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierSortieController extends AbstractController
{
    #[Route('/modifier_sortie/{id}', name: 'app_modifier_sortie', requirements: ['id' => '\d+'], methods: ['POST', 'GET'])]
    public function index(EntityManagerInterface $em, EtatRepository $etatRepository,
                          Sortie                 $sortie, VilleRepository $villeRepository, Request $request): Response
    {
        $villes = $villeRepository->findAll();
        $etatCree = $etatRepository->findByLibelle(Etat::CREE);
        $etatPublier = $etatRepository->findByLibelle(Etat::PUBLIER);
        if ($this->getUser() !== $sortie->getOrganisateur()) {
            throw $this->createAccessDeniedException();
        }

        if ($request->request->has('register')) {
            $sortie->setEtat($etatCree);
        }
        if ($request->request->has('publier')) {
            $sortie->setEtat($etatPublier);
        }

        $form_sortie = $this->createForm(SortieModifierType::class, $sortie);
        $form_sortie->handleRequest($request);

        if ($form_sortie->isSubmitted() && $form_sortie->isValid()) {
            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('modifier_sortie/modifier_sortie.html.twig', [
            'sortie' => $sortie,
            'form_sortie' => $form_sortie,
            'cities' => $villes,

        ]);
    }
}
