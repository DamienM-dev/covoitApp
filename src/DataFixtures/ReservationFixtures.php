<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Ride;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReservationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
            $faker = Factory::create('fr_FR');
    
            for ((int)$i = 0; $i < 20; $i++) {
                $trajets = $manager->getRepository(Ride::class)->findAll();
    
                foreach ($trajets as $trajet) {
                    $reservation = new Reservation();
                    $reservation->setCreatedAt($faker->dateTime());
                    $reservation->setUptatedAt($faker->dateTime());
    
                    // Récupère un utilisateur aléatoire
                    $userId = $faker->numberBetween(1, 20);
                    $user = $manager->getRepository(User::class)->find($userId);
    
                    $reservation->setReservationFrom($user);
                    $reservation->setIdReservationRide($trajet);
    
                    $manager->persist($reservation);
                }
            }

        $manager->flush();
    }
}
