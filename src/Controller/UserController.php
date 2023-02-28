<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
         /**
         * cette méthode affiche les utilisateurs
         * 
         * 
         */
    #[Route('/api/utilisateur', name: 'app_user', methods: ['GET'])]
    public function getAllSubscribe(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $inscription = $userRepository->findAll();
        $inscriptionJson = $serializer->serialize($inscription, 'json', ['groups' => 'getUser']);

        return new JsonResponse($inscriptionJson, 200, [], true);

    }

        /**
         * cette méthode sert à ?
         * 
         * 
         */

    #[Route('/api/register', name:('register_user'), methods:['POST'])]
    public function register(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $register = $serializer->deserialize($request->getContent(),User::class,'json');

        if(!$register) {
            return new JsonResponse(['error' => 'l\'utilisateur est déjà présent dans notre bdd']);
        }


        $entityManagerInterface->persist($register);
        $entityManagerInterface->flush();

        $jsonRegister = $serializer->serialize($register, 'json');

        return new JsonResponse($jsonRegister, 200, [], true);

    }
    // #[Route('api/login', name:'login_user', methods:['POST'])]
    // public function login(Request $request, SerializerInterface $serializer, ManagerRegistry $entityManager): JsonResponse
    // {
        //User envois information => fiat
        //vérifie les données => fait
        //si oui autorise connection => voir comment recevoir token 
        //sinon refuse => fait

        // $login = $request->query->get('login');
        // $pwd = $request->query->get('password');

        // $user = new User;
        // $user->setLogin($login);
        // $user->setPassword($pwd);

        // $em=$entityManager->getManager();
        // $userRepository=$em->getRepository(User::class);

        // $u=$userRepository->findOneBy(['login' => $login]);
        // $p=$userRepository->findOneBy(['password' => $pwd]);

        // if($u && $p === true) {
        //     return new JsonResponse(['good' => 'connexion ok'], 200);
        // } else {
        //     return new JsonResponse(['error' => 'pas de co'], 400);
        // }



        // if(!$login) {
        //     return new JsonResponse(['error' => 'Les informations saisie sont non valide']);
        // }

        // $entityManagerInterface->persist($login);
        // $entityManagerInterface->flush();

        // $jsonLogin = $serializer->serialize($login, 'json');

        // return new JsonResponse([$jsonLogin, 200, [], true]);


        /**
         * cette méthode supprime un utilisateur par son ID
         * 
         * 
         */
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

         /**
         * cette méthode supprime modifie un utilisateur par son ID
         * 
         * 
         */

    #[Route('api/update/utilisateur/{id}', name: 'update_utilisateur', methods: ['PUT'])]
    public function updateUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UserRepository $userRepository, CarRepository $carRepository): JsonResponse
    {

        $updatedUser = $serializer->deserialize($request->getContent(), User::class, 'json');
        // $updatedCar = $serializer->deserialize($request->getContent(), Car::class, 'json');
    
    
        $id = $request->attributes->get('id');
    
        $existingUser = $userRepository->find($id);
        // $existingCar = $carRepository->find();

        if (!$existingUser) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
         } //elseif(!$existingCar) {
        //     return new JsonResponse(['message' => 'voiture non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        // }
    
    
        $existingUser->setName($updatedUser->getName());
        $existingUser->setSurname($updatedUser->getSurname());
        $existingUser->setEmail($updatedUser->getEmail());
        // $existingCar->setTypeOf($updatedCar->getTypeOf());
        // $existingCar->setImmatriculation($updatedCar->getImmatriculation());
        // $existingCar->setNbrPlaces($updatedCar->getNbrPlaces());
        
        $entityManager->flush();
    
        
        return new JsonResponse(['message' => 'Utilisateur mis à jour'], JsonResponse::HTTP_OK);
    }
         /**
         * cette méthode créait un utilisateur
         * 
         * 
         */
        #[Route('/api/post/utilisateur', name:'insert_pers', methods:['POST'])]
public function postUser(ValidatorInterface $validator, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse {
    
    $data = json_decode($request->getContent(), true);
    
    $user = new User();
    $user->setPassword($data['password']);
    $user->setEmail($data['email']);
    $user->setLogin($data['login']);
    $user->setName($data['name']);
    $user->setSurname($data['surname']);
    
    $car = new Car();
    $car->setImmatriculation($data['immatriculation']);
    $car->setNbrPlaces($data['nbr_places']);

    $userId = $user->getId();
    $user = $entityManager->getReference(User::class, $userId);
    $car->addIdFkuser($user);
          
    
    $errors = $validator->validate($user);
    
    if ($errors->count() > 0) {
        return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
    }
    
    $entityManager->persist($user);
    $entityManager->persist($car);
    $entityManager->flush();
    
    $jsonUser = $serializer->serialize($user, 'json');
    return new JsonResponse($jsonUser, 200, [], true);
}

    
    
        /**
         * cette méthode affiche un utilisateur par son ID
         * 
         * 
         */
    #[Route('/api/utilisateur/{id}', name: 'app_one_inscription', methods: ['GET'])]
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

