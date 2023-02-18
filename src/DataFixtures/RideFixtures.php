<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\City;
use App\Entity\Ride;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for( (int)$i = 0; $i < 20; $i++) {

            $trajet = new Ride();
            $trajet->setDistance(800);
            $trajet->setDepartureAt(new \DateTime());
            $trajet->setArrivalAt(new \DateTime());
            $trajet->setPlacesAvailable(5);
            
        }

        $manager->flush();
    }
}
