<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantDetailType;
use App\Form\ParticipantType;
use App\Services\FileUploader;
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
            $participant->setPassword($passwordEncoder->hashPassword($participant, $form->get('password')->getData()));
            $participant->setRoles(['ROLE_USER']);
            $participant->setActif(true);

            $em->persist($participant);
            $em->flush();

            // Redirect to login page after registration
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/register.html.twig', ['form' => $form->createView()]);
    }
    #[Route('/register-detail/{id}', name: 'app_register_detail',requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    public function registerDetail(Request $request,
                                   Participant $participant,
                                   FileUploader $fileUploader
        ,EntityManagerInterface $em): Response
    {
        if ($this->getUser() !== $participant && !$this->isGranted(['ROLE_ADMIN']))
        {
            throw $this->createAccessDeniedException();
        }


        $form = $this->createForm(ParticipantDetailType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Suppression de l'ancienne image
                $fileUploader->delete(
                    $participant->getImage(),
                    $this->getParameter('app.image_profil_directory')
                );
                // Si on a une nouvelle image on la set dans wish
                if ($imageFile) {
                    $participant->setImage($fileUploader->upload($imageFile));
                } // sinon on remet le filename à null.
                else {
                    $participant->setImage(null);
                }
            }
            $em->persist($participant);
            $em->flush();

            // Redirect to login page after registration
            return $this->redirectToRoute('app_home');
        }

        return $this->render('register/register_detail.html.twig', [
            'form' => $form->createView(),
            'participant' => $participant
        ]);
    }

}
