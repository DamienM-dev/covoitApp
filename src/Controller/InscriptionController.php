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
            $reservations = $reservationRepository->findBy(['reservation_from' => $id]);
        
            if (empty($reservations)) {
                return new JsonResponse(['message' => 'Aucune réservation trouvée pour l\'utilisateur donné.'], 404);
            }
        
            $reservationIds = [];
            $reservationDs = [];
            $reservationTs = [];
        
            foreach ($reservations as $reservation) {
                $reservationIds[] = $reservation->getId();
                // $reservationDs[] = $reservation->getCreatedAt();
                // $reservationTs[] = $reservation->getUptatedAt();
            }
        
            $reservationIdsJson = $serializer->serialize(['reservation_ids' => $reservationIds], 'json',['groups' => 'getInfoPassanger'] );
        
            return new JsonResponse($reservationIdsJson, 200, [], true);
        }
        

        #[Route('/api/inscription/conducteur', name: 'app_liste_inscription', methods: ['GET'])]
        public function getDriverByIdRide(ReservationRepository $reservationRepository, SerializerInterface $serializer, EntityManagerInterface $entityManagerInterface): JsonResponse
        {    
            //1) regarder si l'utilisateur est lié à une voiture dans la table car_user
            //2) Si oui il est conducteur et retourner son id
            //3) Récupérer et afficher l'id ride

         
            $reservations = $reservationRepository->findAll();
            foreach($reservations as $reservation) {
                $reservation = $entityManagerInterface->getRepository(Reservation::class)->findOneBy(['id_reservation' => json_decode((string)$reservations)->getIdReservationUser()]);

            }
             $json = $serializer->serialize($reservation, 'json', ['groups' => 'getConducteur']);

        
            return new JsonResponse($json, 200, [], true);
        
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
