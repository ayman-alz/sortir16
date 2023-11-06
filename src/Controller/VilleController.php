<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleFormType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin')]

class VilleController extends AbstractController
{
    #[Route('/ville', name: 'app_ville', methods: ['POST','GET'])]
    public function createville(EntityManagerInterface $em,VilleRepository $repository,Request $request): Response
    {
        $villeGetAll= $repository->findAll();

        $ville = new Ville();
        $ville_form = $this->createForm(VilleFormType::class, $ville);
        $ville_form->handleRequest($request);

        if ($ville_form->isSubmitted() && $ville_form->isValid()) {
            $em->persist($ville);
            $em->flush();

            return $this->redirectToRoute('app_ville');
        }
        return  $this->render('ville/ville_gerer.html.twig',
            [
                'ville_form' => $ville_form->createView(),
                'villeGetAll'=>$villeGetAll
            ]
        );

    }
    #[Route('/ville_modify/{id}/update', name: 'app_create_ville_update', requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    public function updateville(EntityManagerInterface $em,ville $ville,Request $request)
    {
        $ville_form = $this->createForm(VilleFormType::class, $ville);
        $ville_form->handleRequest($request);

        if ($ville_form->isSubmitted() && $ville_form->isValid()) {
            $em->persist($ville);
            $em->flush();

            return $this->redirectToRoute('app_ville');
        }

        return $this->render('ville/ville_modify.html.twig', [
            'ville' => $ville,
            'ville_form' => $ville_form
        ]);
    }

    #[Route('/ville_modify/{id}/delete', name: 'app_create_ville_delete',requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    public function deleteville(EntityManagerInterface $em,ville $ville)
    {

        $em->remove($ville);
        $em->flush();
        return $this->redirectToRoute('app_ville');
    }
}
