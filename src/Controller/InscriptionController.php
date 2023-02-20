<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class InscriptionController extends AbstractController
{
    #[Route('/api/inscription', name: 'app_inscription', methods: ['GET'])]
    public function getAllSubscribe(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $inscription = $userRepository->findAll();
        $inscriptionJson = $serializer->serialize($inscription, 'json', ['groups' => 'getUser']);

        return new JsonResponse($inscriptionJson, 200, [], true);
    }
    #[Route('/api/inscription/{id}', name: 'app_one_inscription', methods: ['GET'])]
    public function getOneSubscribe(int $id, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $inscription = $userRepository->find($id);
        if($inscription) {

            $inscriptionJson = $serializer->serialize($inscription, 'json', ['groups' => 'getUser']);
            return new JsonResponse($inscriptionJson, 200, [], true);
        } else {
            return new JsonResponse(null, 400);
        }

    }

}

