<?php

namespace App\Controller;

use App\Repository\RideRepository;
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
}
