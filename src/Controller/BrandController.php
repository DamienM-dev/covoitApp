<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BrandController extends AbstractController
{
        /**
         * cette méthode retourne toutes les marques de voiture
         * 
         * 
         */
        #[Route('/api/marque', name:'app_marque', methods:['GET'])]
        public function getAllBrand(BrandRepository $BrandRepository): JsonResponse
        {
            $brands = $BrandRepository->findAll();
           
            return $this->json([
                'marques' => $brands,
            ]);
        }


        /**
         * cette méthode supprime une marques de voiture par son id
         * 
         * 
         */
        #[Route('/api/delete/marque/{id}', name: 'delete_marque', methods:['DELETE'])]
            public function deleteBrand(int $id, CarRepository $carRepository, BrandRepository $brandRepository, EntityManagerInterface $entityManager)
            {
                $brand = $brandRepository->find($id);
                
                if (!$brand) {
                    return new JsonResponse(['error' => 'La marque avec cet ID n\'existe pas.'], 404);
                }
                
                $cars = $carRepository->findBy(['type_of' => $brand]);
                
                foreach ($cars as $car) {
                    $entityManager->remove($car);
                }
                
                $entityManager->remove($brand);
                $entityManager->flush();
                
                return new JsonResponse(['message' => 'La marque et les voitures associer ont été supprimées avec succès.'], 200);
            }

        /**
         * cette méthode permet d'enregistrer une nouvelle marque
         * 
         * 
         */
        #[Route('api/post/marque', name: 'post_marque', methods:['POST'])]
        public function postBrand(ValidatorInterface $validator,Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $entityManager): JsonResponse
        {
            $marque = $serializerInterface->deserialize($request->getContent(), Brand::class, 'json');
            $existingBrand = $entityManager->getRepository(Brand::class)->findBy(['brand' => $marque->getBrand()]);

            if ($existingBrand) {
                return new JsonResponse(['error' => 'La marque existe déjà en base de données'], 409);
            }

            $errors = $validator->validate($marque);

            if ($errors->count()> 0) {
                
                return new JsonResponse($serializerInterface->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
            }

    

            $entityManager->persist($marque);
            $entityManager->flush();
        
            $jsonMarque = $serializerInterface->serialize($marque, 'json');
        
            return new JsonResponse($jsonMarque, 200, [], true);
        
        }
}

