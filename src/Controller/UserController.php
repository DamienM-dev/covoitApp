<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/api/utilisateur', name: 'app_user', methods: ['GET'])]
    public function getAllSubscribe(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $inscription = $userRepository->findAll();
        $inscriptionJson = $serializer->serialize($inscription, 'json', ['groups' => 'getUser']);

        return new JsonResponse($inscriptionJson, 200, [], true);
    
    }

    #[Route('/api/delete/utilisateur/{id}', name: 'delete_user', methods:['DELETE'])]
    public function deleteCar(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $userDelete = $userRepository->find($id);
    
        if (!$userDelete) {
            return new JsonResponse(['error' => 'L\'utilisateur avec cet ID n\'existe pas.'], 404);
        }
    
        $entityManager->remove($userDelete);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'L\'utilisateur a été supprimée avec succès.'], 200);
    }
    
    #[Route('/api/inscription/{id}', name: 'app_one_inscription', methods: ['GET'])]
    public function getOneSubscribe(int $id, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $inscription = $userRepository->find($id);
        if($inscription) {

            $inscriptionJson = $serializer->serialize($inscription, 'json', ['groups' => 'getUser']);
            return new JsonResponse($inscriptionJson, 200, [], true);
        } else {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }
    }

}

