<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    #[Route('/lieu', name: 'app_lieu')]
    public function index(LieuRepository $lieuRepository, VilleRepository $villeRepository, Request $request): Response
    {
        $villes = $villeRepository->findAll();
        $selectedCity = $request->get('city');
        $lieus = [];
        if ($selectedCity) {
            $lieus = $lieuRepository->findBy(['ville' => $selectedCity]);
        }
        return $this->render('lieu/index.html.twig', [
            'cities' => $villes,
            'lieus' => $lieus,
        ]);
    }

    #[Route('/add_lieu', name: 'app_add_lieu')]
    public function addLieu(Request $request, EntityManagerInterface $em, VilleRepository $villeRepository): Response
    {

        $lieuName = $request->request->get('lieu_name');
        $rue = $request->request->get('rue');
        $latitude = $request->request->get('latitude');
        $longitude = $request->request->get('longitude');
        $cityId = $request->request->get('city');

        $ville = $villeRepository->find($cityId);

        if (!$ville) {
            throw $this->createNotFoundException('City not found');
        }

        $lieu = new Lieu();
        $lieu->setNom($lieuName);
        $lieu->setRue($rue);
        $lieu->setLatitude($latitude);
        $lieu->setLongitude($longitude);
        $lieu->setVille($ville);

        $em->persist($lieu);
        $em->flush();

        // Yeni Lieu ekledikten sonra, sayfayı güncelleyerek seçilen şehirle geri dönün
        return $this->redirectToRoute('app_creation_sortie', ['city' => $cityId]);
    }

    #[Route('/get_lieu_names', name: 'app_get_lieu_names')]
    public function getLieuNames(Request $request, LieuRepository $lieuRepository): JsonResponse
    {
        $cityId = $request->query->get('cityId');
        $lieus = $lieuRepository->findBy(['ville' => $cityId]);
        $data = [];
        foreach ($lieus as $lieu) {
            $data[] = [
                'id' => $lieu->getId(),
                'nom' => $lieu->getNom(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/get_lieu_details', name: 'app_get_lieu_details')]
    public function getLieuDetails(Request $request,LieuRepository $lieuRepository): JsonResponse
    {
        $lieuId = $request->query->get('lieuId');
        $lieu = $lieuRepository->find($lieuId);

        if (!$lieu) {
            return new JsonResponse(['error' => 'Lieu not found']);
        }

        $data = [
            'nom' => $lieu->getNom(),
            'rue' => $lieu->getRue(),
            'latitude' => $lieu->getLatitude(),
            'longitude' => $lieu->getLongitude(),
        ];

        return new JsonResponse($data);
    }

}
