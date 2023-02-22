<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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

    #[Route('api/update/utilisateur/{id}', name: 'update_utilisateur', methods: ['PUT'])]
    public function updateUser(Request $request, User $user, SerializerInterface $serializer, EntityManagerInterface $entityManager, UserRepository $userRepository): JsonResponse
    {
        // Désérialiser la requête PUT en objet User
        $updatedUser = $serializer->deserialize($request->getContent(), User::class, 'json');
    
        // Récupérer l'ID de l'utilisateur à mettre à jour depuis la route
        $id = $request->attributes->get('id');
    
        $existingUser = $userRepository->find($id);
        if (!$existingUser) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }
    
    
        $existingUser->setName($updatedUser->getName());
        $existingUser->setSurname($updatedUser->getSurname());
        $existingUser->setEmail($updatedUser->getEmail());
        
    
    
        $entityManager->flush();
    
        
        return new JsonResponse(['message' => 'Utilisateur mis à jour'], JsonResponse::HTTP_OK);
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

