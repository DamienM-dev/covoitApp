<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    #[Route('/api/voiture', name: 'app_voiture', methods:['GET'])]
    public function GetAllCar(CarRepository $carRepository): JsonResponse
    {
        $voiture = $carRepository->findAll();
        return $this->json([
            'voitures' => $voiture,
           
        ]);
    }


    
}
