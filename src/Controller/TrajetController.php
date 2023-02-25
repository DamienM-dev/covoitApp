<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Repository\RideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

        if (!$deleteRide) {
            return new JsonResponse(['error' => 'Le trajet avec cet ID n\'existe pas.'], 404);
        } else {
           
            foreach ($deleteRide->getIdRideUser() as $user) {
                $entityManager->remove($user);
            }
            
            $entityManager->remove($deleteRide);
            $entityManager->flush();
        
            return new JsonResponse(['message' => 'Le trajet a été supprimé avec succès.'], 200);
        }
    }

    #[Route('api/post/trajet', name:'post_trajet', methods:['POST'])]
    public function postRide(Request $request, EntityManagerInterface $entityManagerInterface, SerializerInterface $serializerInterface): JsonResponse
    {
        $trajet = $serializerInterface->deserialize($request->getContent(), Ride::class,'json');


        $entityManagerInterface->persist($trajet);
        
        $entityManagerInterface->flush();

        $jsonTrajet = $serializerInterface->serialize($trajet, 'json');

    
        return new JsonResponse(['message' => 'ok'], 200);

    }

    #[Route('api/get/trajet/{villeD}/{villeA}', name:'get_trajet', methods:['GET'])]
    public function getFromManyThing(Request $request, int $villeD, int $villeA, ManagerRegistry $doctrine): JsonResponse
    {
      
        if ($request->isMethod('GET')) {
            $em = $doctrine->getManager();
            $trajet = $em->getRepository(Ride::class)->find($villeD, $villeA);
            $resultat = [
                "id" => $trajet->getId(),
                "city_departure" => $trajet->getCityDeparture(),
                "city_arrival" => $trajet->getCityArrival(),
                ""];
        } else {
            $resultat = ["Pas de trajet correspondant"];
        }
        return new JsonResponse($resultat);
    }
}
