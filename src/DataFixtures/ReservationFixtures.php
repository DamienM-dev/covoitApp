<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Ride;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $trajets = $manager->getRepository(Ride::class)->findAll();

            foreach ($trajets as $trajet) {
                $reservation = new Reservation();
                $reservation->setCreatedAt(new \DateTime());
                $reservation->setUptatedAt(new \DateTime());
                        
                $reservation->setIdReservationRide($trajet);

                $manager->persist($reservation);
            }
           
        

        $manager->flush();
    }
}
