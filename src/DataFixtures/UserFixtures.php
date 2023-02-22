<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Ride;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
            $faker = Factory::create('fr_FR');

        for( (int)$i = 0; $i < 20; $i++) {

            
            $reservation = $manager->getRepository(Reservation::class)->findOneBy(['id' => $i]);
            $trajets = $manager->getRepository(Ride::class)->findAll();


            foreach ($trajets as $trajet) {
            $utilisateur = new User();
            $utilisateur->setLogin("Raphou".$i);
            $utilisateur->setName($faker->lastName());
            $utilisateur->setSurname($faker->firstname());
            $utilisateur->setEmail($faker->email());
            $utilisateur->setPassword($faker->password());
            

        
            $utilisateur->setRide($trajet);

        

            $manager->persist($utilisateur);
            
            }
        }

        $manager->flush();
    }
}
