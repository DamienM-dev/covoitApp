<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
}

