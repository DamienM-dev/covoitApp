<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\City;
use App\Entity\User;
use App\Repository\CarRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VoitureController extends AbstractController
{
        /**
         * cette méthode affiche les voitures
         * 
         * 
         */
    #[Route('/api/voiture', name: 'app_voiture', methods:['GET'])]
    public function getAllCar(CarRepository $carRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $voiture = $carRepository->findAll();
        $voitureJson = $serializerInterface->serialize($voiture, 'json', ['groups' => 'getCar']);

        return new JsonResponse($voitureJson, 200, [], true);
    }

        /**
         * cette méthode permet d'insérer une voiture
         * 
         * 
         */
    #[Route('/api/post/voiture', name: 'post_voiture', methods:['POST'])]
    public function postCar(ValidatorInterface $validator,Request $request, EntityManagerInterface $entityManagerInterface, SerializerInterface $serializerInterface): JsonResponse
    {
        $voiture = $serializerInterface->deserialize($request->getContent(),Car::class, 'json');
      
        $errors = $validator->validate($voiture);

        if ($errors->count()> 0) {
            
            return new JsonResponse($serializerInterface->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }


        $entityManagerInterface->persist($voiture);
        $entityManagerInterface->flush();
    
        $jsonVoiture = $serializerInterface->serialize($voiture, 'json');
    
        return new JsonResponse($jsonVoiture, 200, [], true);
        
        
    }

        /**
         * cette méthode supprime une voiture par son ID
         * 
         * 
         */

    #[Route('/api/delete/voiture/{id}', name: 'delete_voiture', methods:['DELETE'])]
    public function deleteCar(int $id, CarRepository $carRepository, EntityManagerInterface $entityManager)
    {
        $car = $carRepository->find($id);
    
        if (!$car) {
            return new JsonResponse(['error' => 'La voiture avec cet ID n\'existe pas.'], 404);
        }

        
        foreach ($car->getIdFkuser() as $user) {
  
        $userId = $user->getId();
        }
    
        $user = $entityManager->getReference(User::class, $userId);
        $car->removeIdFkuser($user);
        $entityManager->remove($car);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'La voiture a été supprimée avec succès.'], 200);
    }
    
}
