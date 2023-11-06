<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\SortieFormType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CreationSortieController extends AbstractController
{

    #[Route('/get_Lieu', name: 'app_sortie_getId')]
    #[IsGranted('ROLE_USER', statusCode: 404, message: 'NOT ACCES ')]
    public function get(Request $request)
    {
        $session = $request->getSession();
        $lieuId = $request->request->get('lieuId');
        $session->set('lieu', $lieuId);
        return new Response('');
    }

    #[IsGranted('ROLE_USER', statusCode: 404, message: 'NOT ACCES ')]
    #[Route('/creation_sortie', name: 'app_creation_sortie',methods: ['GET','POST'])]
    public function index(LieuRepository         $lieuRepository,
                          VilleRepository        $villeRepository,
                          EtatRepository $etatRepository,
                          Request                $request,
                          EntityManagerInterface $em
    ): Response
    {
        $villes = $villeRepository->findAll();
        $etat =$etatRepository->findByLibelle(Etat::CREE);
        $session = $request->getSession();
        $sortie= new Sortie();
        $sortie->setOrganisateur($this->getUser());
        $sortie->setCampus($this->getUser()->getCampus());
        $sortie->setEtat($etat);
        $form_sortie = $this->createForm(SortieFormType::class,$sortie);
        $form_sortie->handleRequest($request);


        if ($form_sortie->isSubmitted() && $form_sortie->isValid()) {
            $lieuId = $session->get('lieu');
            if ($lieuId)
            {
                $lieu = $lieuRepository->find($lieuId);
                $sortie->setLieu($lieu);
            } else {
                throwException('Lieu is null');
            }
            $em->persist($sortie);
            $em->flush();
            return $this ->redirectToRoute('app_home');

        }
        return $this->render('creation_sortie/create_sortie.html.twig', [
            'form_sortie' => $form_sortie,
            'cities' => $villes,
        ]);
    }


}
