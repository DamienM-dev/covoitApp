<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BrandController extends AbstractController
{
  
        #[Route('/api/marque', name:'app_marque', methods:['GET'])]
        public function getAllBrand(BrandRepository $BrandRepository): JsonResponse
        {
            $brands = $BrandRepository->findAll();
           
            return $this->json([
                'marques' => $brands,
            ]);
        }

        #[Route('/api/delete/marque/{id}', name: 'delete_marque', methods:['DELETE'])]
        public function deleteCar(int $id, BrandRepository $brandRepository, EntityManagerInterface $entityManager)
        {
            $brand = $brandRepository->find($id);
        
            if (!$brand) {
                return new JsonResponse(['error' => 'La marque avec cet ID n\'existe pas.'], 404);
            }
        
            $entityManager->remove($brand);
            $entityManager->flush();
        
            return new JsonResponse(['message' => 'La marque a été supprimée avec succès.'], 200);
        }

        #[Route('api/post/marque', name: 'post_marque', methods:['POST'])]
        public function postBrand(Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $entityManager): JsonResponse
        {
            $marque = $serializerInterface->deserialize($request->getContent(), Brand::class, 'json');
            $existingBrand = $entityManager->getRepository(Brand::class)->findBy(['brand' => $marque->getBrand()]);

            if ($existingBrand) {
                return new JsonResponse(['error' => 'La marque existe déjà en base de données'], 409);
            }

            $entityManager->persist($marque);
            $entityManager->flush();
        
            $jsonMarque = $serializerInterface->serialize($marque, 'json');
        
            return new JsonResponse($jsonMarque, 200, [], true);
        
        }
}

