<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\City;
use App\Entity\Ride;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RideFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $villes = $manager->getRepository(City::class)->findAll();

       

            $villeDepart = $villes[array_rand($villes)];
            $villeArrivee = $villes[array_rand($villes)];

            $trajet = new Ride();
            $trajet->setDistance(800);
            $trajet->setDepartureAt(new \DateTime());
            $trajet->setArrivalAt(new \DateTime());
            $trajet->setPlacesAvailable(5);

            $trajet->setCityDeparture($villeDepart);
            $trajet->setCityArrival($villeArrivee);

            $manager->persist($trajet);
        

        $manager->flush();
    }
}
