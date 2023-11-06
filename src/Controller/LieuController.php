<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    #[Route('/lieu', name: 'app_lieu')]
    public function index(EntityManagerInterface $em,Request $request): Response
    {


       $lieu = new Lieu();
       $lieu_form = $this->createForm(LieuFormType::class, $lieu);
       $lieu_form->handleRequest($request);

        if ($lieu_form->isSubmitted() && $lieu_form->isValid()) {
            $em->persist($lieu);
            $em->flush();

            return $this->redirectToRoute('app_create_campus');
        }

        return $this->render('lieu/index.html.twig', [
            'lieu_form' => $lieu_form->createView(),
        ]);
    }


}
