<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    #[Route('/api/voiture', name: 'app_voiture', methods:['GET'])]
    public function getAllCar(CarRepository $carRepository): JsonResponse
    {
        $voiture = $carRepository->findAll();
        return $this->json([
            'voitures' => $voiture,
           
        ]);
    }

    #[Route('/api/delete/voiture/{id}', name: 'delete_voiture', methods:['DELETE'])]
    public function deleteCar(int $id, CarRepository $carRepository, EntityManagerInterface $entityManager)
    {
        $car = $carRepository->find($id);
    
        if (!$car) {
            return new JsonResponse(['error' => 'La voiture avec cet ID n\'existe pas.'], 404);
        }
    
        $entityManager->remove($car);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'La voiture a été supprimée avec succès.'], 200);
    }
    
}
