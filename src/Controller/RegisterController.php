<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{



    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder,EntityManagerInterface $em): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Encode the password
            $participant->setMotPasse($passwordEncoder->hashPassword($participant, $form->get('motPasse')->getData()));

            $em->persist($participant);
            $em->flush();

            // Redirect to login page after registration
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/register.html.twig', ['form' => $form->createView()]);
    }

}
