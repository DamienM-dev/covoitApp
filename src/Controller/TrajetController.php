<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Ride;
use App\Repository\RideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TrajetController extends AbstractController
{

        /**
         * cette méthode affiche tout les trajets
         * 
         * 
         */
    #[Route('/api/trajet', name: 'app_trajet', methods:['GET'])]
    public function getAllRide(RideRepository $rideRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $trajet = $rideRepository->findAll();
        $trajetJson = $serializerInterface->serialize($trajet, 'json', ['groups' => 'getRide']);

        return new JsonResponse($trajetJson, 200, [], true);
    }

        /**
         * cette méthode supprime un trajet par son ID
         * 
         * 
         */
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

        /**
         * cette méthode permet la création d'un trajet
         * 
         * 
         */

    #[Route('api/post/trajet', name:'post_trajet', methods:['POST'])]
    public function postRide(ValidatorInterface $validator,Request $request, EntityManagerInterface $entityManagerInterface, SerializerInterface $serializerInterface): JsonResponse
    {
        $trajet = $serializerInterface->deserialize($request->getContent(), Ride::class,'json');
        $villeD = $serializerInterface->deserialize($request->getContent(), City::class,'json');

        $errors = $validator->validate($trajet);
        

        if ($errors->count()> 0) {
            
            return new JsonResponse($serializerInterface>serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        

        $entityManagerInterface->persist($villeD);
        $entityManagerInterface->persist($trajet);
        
        $entityManagerInterface->flush();

        $jsonTrajet = $serializerInterface->serialize($trajet, 'json');

    
        return new JsonResponse(['message' => 'ok'], 200);

    }

        /**
         * cette méthode permet de rechercher un trajet par sa ville d'arivée et de départ
         * 
         * 
         */
    #[Route('/api/get/trajet/{villeDepart}/{villeArrivee}', name: 'get_trajet', methods: ['GET'])]
    public function getTrajet(string $villeDepart, string $villeArrivee, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $trajets = $em->getRepository(Ride::class)->findBy(['city_departure' => $villeDepart, 'city_arrival' => $villeArrivee]);
        
        $resultats = [];
        foreach ($trajets as $trajet) {
            $resultats[] = [
                'id' => $trajet->getId(),
                'departure_at'=>$trajet->getDepartureAt(),
                'arrival_at'=>$trajet->getArrivalAt(),
            ];
        }
    
        if (count($resultats) > 0) {
            return new JsonResponse($resultats);
        } else {
            return new JsonResponse(['Pas de trajet correspondant']);
        }
    }
}
