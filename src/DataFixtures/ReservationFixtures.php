<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for( (int)$i = 0; $i < 20; $i++) {



            $reservation = new Reservation();
            $reservation->setCreatedAt(new \DateTime());
            $reservation->setUptatedAt(new \DateTime());
          
        }

        $manager->flush();
    }
}
