<?php

namespace App\Controller;

use App\Repository\RideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TrajetController extends AbstractController
{
    #[Route('/api/trajet', name: 'app_trajet', methods:['GET'])]
    public function getAllRide(RideRepository $rideRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $trajet = $rideRepository->findAll();
        $trajetJson = $serializerInterface->serialize($trajet, 'json', ['groups' => 'getRide']);

        return new JsonResponse($trajetJson, 200, [], true);
    }

    #[Route('api/delete/trajet/{id}', name: 'delete_trajet', methods:['DELETE'])]
    public function deleteRide(int $id, RideRepository $rideRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $deleteRide = $rideRepository->find($id);

        if(!$deleteRide) {
            return new JsonResponse(['error' => 'Le trajet avec cet ID n\'existe pas.'], 404);
        } else 
        {
            $entityManager->remove($deleteRide);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Le trajet a été supprimée avec succès.'], 200);
        }
    }
}
