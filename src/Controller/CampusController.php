<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusFormType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin')]
class CampusController extends AbstractController
{
    #[Route('/campus', name: 'app_create_campus', methods: ['POST','GET'])]
    public function createCampus(EntityManagerInterface $em,CampusRepository $repository,Request $request): Response
    {
        $campusGetAll= $repository->findAll();

        $campus = new Campus();
        $campus_form = $this->createForm(CampusFormType::class, $campus);
        $campus_form->handleRequest($request);

        if ($campus_form->isSubmitted() && $campus_form->isValid()) {
            $em->persist($campus);
            $em->flush();

            return $this->redirectToRoute('app_create_campus');
        }
        return  $this->render('campus/campus_gerer.html.twig',
        [
            'campus_form' => $campus_form->createView(),
            'campusGetAll'=>$campusGetAll
        ]
        );

    }
    #[Route('/campus_modify/{id}/update', name: 'app_create_campus_update', requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    public function updateCampus(EntityManagerInterface $em,Campus $campus,Request $request)
    {
        $campus_form = $this->createForm(CampusFormType::class, $campus);
        $campus_form->handleRequest($request);

        if ($campus_form->isSubmitted() && $campus_form->isValid()) {
            $em->persist($campus);
            $em->flush();

            return $this->redirectToRoute('app_create_campus');
        }

        return $this->render('campus/campus_modify.html.twig', [
            'campus' => $campus,
            'campus_form' => $campus_form
        ]);
    }

    #[Route('/campus_modify/{id}/delete', name: 'app_create_campus_delete',requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    public function deleteCampus(EntityManagerInterface $em,Campus $campus)
    {

            $em->remove($campus);
            $em->flush();
            return $this->redirectToRoute('app_create_campus');
    }


}
