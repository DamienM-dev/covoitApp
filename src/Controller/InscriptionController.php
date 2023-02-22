<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class InscriptionController extends AbstractController
{
    
        #[Route('/api/inscription', name: 'app_inscription', methods: ['GET'])]
        public function getAllSubscribe(ReservationRepository $userRepository, SerializerInterface $serializer): JsonResponse
        {
            $inscription = $userRepository->findAll();
            $inscriptionJson = $serializer->serialize($inscription, 'json', ['groups' => 'getUser']);
    
            return new JsonResponse($inscriptionJson, 200, [], true);
        }

        #[Route('/api/delete/inscription/{id}', name: 'delete_inscription', methods:['DELETE'])]
        public function deleteSubscribe(int $id, ReservationRepository $reservationRepository, EntityManagerInterface $entityManagerInterface)
        {
            $deleteSubscribe = $reservationRepository->find($id);

            if(!$deleteSubscribe) {
                return new JsonResponse(['error' => 'L\'inscription avec cet ID n\'existe pas.'], 404);


            } else {
                $entityManagerInterface->remove($deleteSubscribe);
                $entityManagerInterface->flush();
                return new JsonResponse(['message' => 'La suppression de l\'inscription est réussite'], 200);
            }

        }
}
