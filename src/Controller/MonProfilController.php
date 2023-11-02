<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonProfilController extends AbstractController
{

    #[Route('/mon_profil/{id}', name: 'app_mon_profil_1')]
    public function profimById2(ParticipantRepository $repository, $id): Response
    {
        $participant = $repository->find($id);

        return $this->render('mon_profil/mon_profil.html.twig', [
            'participant' => $participant
        ]);

    }
    #[Route('/mon_profil', name: 'app_mon_profil')]
    public function profim(ParticipantRepository $repository, $id): Response
    {

        return $this->render('mon_profil/mon_profil.html.twig', );

    }
    /*
     *
#[Route('/mon_profil', name: 'app_mon_profil')]
public function index(ParticipantRepository $repository): Response
{
   $participants= $repository->findAll();

   return $this->render('mon_profil/mon_profil.html.twig', [
   ]);
}

#[Route('/mon_profil/{id}', name: 'app_mon_profil_id')]
public function profimById(Participant $participant): Response
{
  return  new Response(sprintf("%s", $participant->__toString()));
}



#[Route('/mon_profil/delete/{id}', name: 'app_mon_profil_delete')]
public function deleteProfil(ParticipantRepository $repository, EntityManagerInterface $em,$id): Response
{
  $participant = $repository->find($id);
  if (!$participant) {
      return $this-> createNotFoundException('Unable to find participant');
  }

  $em->remove($participant);
  $em->flush();

  return new Response( printf('successfully delete '));
}

#[Route('/mon_profil/update/{id}', name: 'app_mon_profil')]
public function updateProfil(ParticipantRepository $repository, EntityManagerInterface $em, Request $request,$id): Response
{
  $nom = $request->get('nom');
  $participant = $repository->find($id);

  $participant->setNom($nom);

  $em->persist($participant);
  $em->flush();

 return new Response( printf('successfully name change %s', $participant->getNom()));

}
*/
}
