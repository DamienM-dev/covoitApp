<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Ride;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for( (int)$i = 0; $i < 20; $i++) {

            
            $reservation = $manager->getRepository(Reservation::class)->findOneBy(['id' => $i]);
            $trajets = $manager->getRepository(Ride::class)->findAll();


            foreach ($trajets as $trajet) {
            $utilisateur = new User();
            $utilisateur->setLogin("Raphou".$i);
            $utilisateur->setName("Raphaêl".$i);
            $utilisateur->setSurname("Etdonatelo");
            $utilisateur->setEmail('raphoudu5'.$i.'@mail.com');
            $utilisateur->setPassword("MotDePasseIncracable");
            $utilisateur->setLogin("Raphou".$i);

            $utilisateur->setReservation($reservation);
            $utilisateur->setRide($trajet);

        

            $manager->persist($utilisateur);
            }
        }

        $manager->flush();
    }
}
