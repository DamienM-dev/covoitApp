<?php

namespace App\Controller;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    #[Route('/api/ville', name: 'app_ville', methods: ['GET'])]
    public function getAllCity(CityRepository $cityRepository): JsonResponse
    {
        $ville = $cityRepository->findAll();

        return $this->json([
            'Inscriptions' => $ville,
        ]);
    }
}
