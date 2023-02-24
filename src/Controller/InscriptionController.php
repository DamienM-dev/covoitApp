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
        
        #[Route('/api/inscription/utilisateur/{id}', name: 'app_liste_inscription', methods: ['GET'])]
        public function getSubscribeById(int $id, ReservationRepository $reservationRepository, SerializerInterface $serializer): JsonResponse
        {
            $reservations = $reservationRepository->findOneBy(['reservation_from' => $id]);
            //verif si existe
            //get trajetid

            //même chose avec trajet
            
            $reservationIdJson = $serializer->serialize($reservations, 'json');
        
            return new JsonResponse($reservationIdJson, 200, [], true);
        }

        // #[Route('/api/inscription/conducteur', name: 'app_liste_inscription', methods: ['GET'])]
        // public function getSubscribeById(ReservationRepository $reservationRepository, SerializerInterface $serializer, EntityManagerInterface $entityManagerInterface): JsonResponse
        // {    
            // Récupérer l'id de id_reservation;
            //     comparer avec l'id utilisateur
            //     et si cela match afficher

            // $reservations = $reservationRepository->findAll();
            // foreach($reservations as $reservation) {
            //     $reservation = $entityManagerInterface->getRepository(Reservation::class)->findOneBy(['id_reservation' => json_decode((string)$reservations)->getIdReservationUser()]);

            // }
            //  $json = $serializer->serialize($reservation, 'json', ['groups' => 'getConducteur']);

        
            // return new JsonResponse($json, 200, [], true);
        
        
           
        

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
