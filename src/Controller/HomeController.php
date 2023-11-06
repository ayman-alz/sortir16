<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home',methods: ['GET', 'POST'])]
    public function index(SortieRepository $sortieRepository,Request $request, PaginatorInterface $paginator): Response
    {
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



    #[Route('/filter', name: 'app_filter')]
    public function filter(FilterReposotory $reposotory)
    {

        $filters = $reposotory -> findSearch();
        return $this->render('home/home.html.twig', [
            'filters' => '$filters',
        ]);
    }
}
