<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\Model\SortieFilter;
use App\Form\SearchFormType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function filterIndex(SortieRepository $sortieRepository,EntityManagerInterface $em, EtatRepository $etatRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $sortieFilter = new SortieFilter();
        $form = $this->createForm(SearchFormType::class, $sortieFilter);
        $form->handleRequest($request);
        $sorties = $sortieRepository->getWithFilters($sortieFilter);
        $sorties = $this->updateEtat($em, $sorties,$etatRepository);


        $page = $request->query->getInt('page', 1);
        $limit = 5;

        $pagination = $paginator->paginate(
            $sorties, // Sayfalayacağınız koleksiyon
            $page,    // Sayfa numarası
            $limit    // Sayfa başına sonuç sayısı
        );
        return $this->render('home/home.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form
        ]);


    }


    #[Route('/publier/{id}', name: 'app_home-publier',methods: ['GET', 'POST'])]
    public function publierSortie(SortieRepository $sortieRepository,EtatRepository $etatRepository,EntityManagerInterface $em,$id): Response
    {
        $sortie = $sortieRepository->find($id);
        if ( $this->getUser()  !== $sortie->getOrganisateur())
        {
            throw $this->createAccessDeniedException();
        }
        $etatPublier = $etatRepository->findByLibelle(Etat::PUBLIER);
        $sortie->setEtat($etatPublier);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
    #[Route('/sinscrir/{id}', name: 'app_home-inscrir',methods: ['GET', 'POST'])]
    public function sinscrirSortir(SortieRepository $sortieRepository,EntityManagerInterface $em,$id): Response
    {
        $sortie = $sortieRepository->find($id);
        $sortie->addParticipant($this->getUser() );

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
    #[Route('/sdesister/{id}', name: 'app_home-desister',methods: ['GET', 'POST'])]
    public function sdesisterSortie(SortieRepository $sortieRepository,EntityManagerInterface $em,$id): Response
    {
        $sortie = $sortieRepository->find($id);
        $sortie->removeParticipant($this->getUser());
        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/afficher/{id}', name:'app_afficiher_sortir',methods:['GET'])]
    public function afficiherSortir($id,SortieRepository $sortieRepository)
    {
        $sorties = $sortieRepository->find($id);
        return $this->render('creation_sortie/afficher_sortie.html.twig', [
            'sorties' => $sorties,
        ]);
    }

    public function updateEtat(EntityManagerInterface $em,$sorties ,EtatRepository $etatRepository){

        $etatCloutere =$etatRepository->findByLibelle(Etat::TERMINE);
        $etatPasse =$etatRepository->findByLibelle(Etat::PASSE);
        $etatEncors =$etatRepository->findByLibelle(Etat::ACTIVE);


        foreach ($sorties as $sortie){
            if($sortie->getEtat()->getLibelle() === Etat::PUBLIER){
                if ($sortie->getDateLimiteInscription() < new \DateTime()) {
                    $sortie->setEtat($etatCloutere);
                    $em->persist($sortie);
                }
                if ($sortie->getDateHeureDebut() < new \DateTime()) {
                    $sortie->setEtat($etatPasse);
                    $em->persist($sortie);
                }
                if ($sortie->getDateHeureDebut() == new \DateTime()) {
                    $sortie->setEtat($etatEncors);
                    $em->persist($sortie);
                }
            }

        }

        $em->flush();

        return $sorties;
    }
}
