<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class VilleController extends AbstractController
{
    #[Route('/api/ville', name: 'app_ville', methods: ['GET'])]
    public function getAllCity(CityRepository $cityRepository): JsonResponse
    {
        $ville = $cityRepository->findAll();

        return $this->json([
            'Inscriptions' => $ville,
        ]);
    }

    #[Route('api/delete/ville/{id}', name: 'app_ville', methods:['DELETE'])]
    public function getDeleteCity(int $id, CityRepository $cityRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $deleteCity = $cityRepository->find($id);

        if (!$deleteCity) {
            return new JsonResponse(['error' => 'La ville avec cet ID n\'existe pas.'], 404);
        }
    
        $entityManager->remove($deleteCity);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'La ville a été supprimée avec succès.'], 200);
    }

    #[Route('api/post/ville', name:'ajouter_livre', methods:['POST'])]
public function createCity(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
{
    $city = $serializer->deserialize($request->getContent(), City::class, 'json');

    $existingCity = $entityManager->getRepository(City::class)->findOneBy(['name' => $city->getName()]);

    if ($existingCity) {
        return new JsonResponse(['error' => 'La ville existe déjà en base de données'], 409);
    }

    $entityManager->persist($city);
    $entityManager->flush();

    $jsonCity = $serializer->serialize($city, 'json');

    return new JsonResponse($jsonCity, 200, [], true);
}



    #[Route('/api/postal', name: 'code_postal', methods: ['GET'])]
public function getAllCp(CityRepository $cityRepository): JsonResponse
{
    $cities = $cityRepository->findAll();
    $codes_postaux = array();
    foreach ($cities as $city) {
        $codes_postaux[] = $city->getCp();
    }
    return $this->json([
        'codes_postaux' => $codes_postaux,
    ]);
}
}
