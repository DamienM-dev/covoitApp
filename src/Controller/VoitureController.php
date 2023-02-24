<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\City;
use App\Repository\CarRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    #[Route('/api/post/voiture', name: 'post_voiture', methods:['POST'])]
    public function postCar(Request $request, EntityManagerInterface $entityManagerInterface, SerializerInterface $serializerInterface): JsonResponse
    {
        $voiture = $serializerInterface->deserialize($request->getContent(),Car::class, 'json');
        //$existingCar = $entityManagerInterface->getRepository(['immatriculation' => $voiture->getImmatriculation()]);

        //if(!$existingCar) {
          // return new JsonResponse(['La voiture est déjà existante dans nos bases de données'], 400);
       //}


        $entityManagerInterface->persist($voiture);
        $entityManagerInterface->flush();
    
        $jsonVoiture = $serializerInterface->serialize($voiture, 'json');
    
        return new JsonResponse($jsonVoiture, 200, [], true);
        
        
    }

    // #[Route('/api/delete/voiture/{id}', name: 'delete_voiture', methods:['DELETE'])]
    // public function deleteCar(int $id, CarRepository $carRepository, EntityManagerInterface $entityManager)
    // {
    //     $car = $carRepository->find($id);
    
    //     if (!$car) {
    //         return new JsonResponse(['error' => 'La voiture avec cet ID n\'existe pas.'], 404);
    //     }

        
    //     foreach ($car->getIdFkuser() as $user) {
  
    //     $userId = $user->getId();
    //     }
    
    //     $car->removeIdFkuser($userId);
    //     $entityManager->remove($car);
    //     $entityManager->flush();
    
    //     return new JsonResponse(['message' => 'La voiture a été supprimée avec succès.'], 200);
    // }
    
}
