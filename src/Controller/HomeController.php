<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use function Symfony\Component\Clock\now;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home',methods: ['GET', 'POST'])]
    public function index(SortieRepository $sortieRepository,Request $request, PaginatorInterface $paginator,EntityManagerInterface $em): Response
    {
        $this->updateEtat($sortieRepository,$em);
        $sorties = $sortieRepository->findAll();

        $page = $request->query->getInt('page', 1);
        $limit = 7;

        $pagination = $paginator->paginate(
            $sorties, // Sayfalayacağınız koleksiyon
            $page,    // Sayfa numarası
            $limit    // Sayfa başına sonuç sayısı
        );
        return $this->render('home/home.html.twig', [
            'sorties' => $sorties,
            'pagination' => $pagination
        ]);
    }

    #[Route('/publier/{id}', name: 'app_home-publier',methods: ['GET', 'POST'])]
    public function publierSortie(SortieRepository $sortieRepository,EntityManagerInterface $em,$id): Response
    {
        $sortie = $sortieRepository->find($id);
        $sortie->getEtat()->setLibelle(Etat::PUBLIER);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
    #[Route('/sinscrir/{id}', name: 'app_home-inscrir',methods: ['GET', 'POST'])]
    public function sinscrirSortir(SortieRepository $sortieRepository,EntityManagerInterface $em,$id): Response
    {
        $sortie = $sortieRepository->find($id);
        $sortie->getEtat()->setLibelle(Etat::PUBLIER);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
    #[Route('/sdesister/{id}', name: 'app_home-desister',methods: ['GET', 'POST'])]
    public function sdesisterSortie(SortieRepository $sortieRepository,EntityManagerInterface $em,$id): Response
    {
        $sortie = $sortieRepository->find($id);
        $sortie->getEtat()->setLibelle(Etat::PUBLIER);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }

    public function updateEtat(SortieRepository $sortieRepository,EntityManagerInterface $em ){

        $sorties = $sortieRepository->findAll();
        foreach ($sorties as $sortie){
            if($sortie->getEtat()->getLibelle() === Etat::PUBLIER){
                if ($sortie->getDateLimiteInscription() < new \DateTime()) {
                    $sortie->getEtat()->setLibelle(Etat::TERMINE); // Çıkışın durumunu ayarla
                    $em->persist($sortie);
                    $em->flush();
                }
            }

        }
    }
}
