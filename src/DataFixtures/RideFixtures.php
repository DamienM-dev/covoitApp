<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Ride;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RideFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $villes = $manager->getRepository(City::class)->findAll();

      
       

            $villeDepart = $villes[array_rand($villes)];
            $villeArrivee = $villes[array_rand($villes)];

            $trajet = new Ride();
            $trajet->setDistance($faker->numberBetween(0, 2000));
            $trajet->setDepartureAt($faker->dateTime());
            $trajet->setArrivalAt($faker->dateTime());
            $trajet->setPlacesAvailable($faker->numberBetween(0, 6));

            $trajet->setCityDeparture($villeDepart);
            $trajet->setCityArrival($villeArrivee);

            $manager->persist($trajet);
        

        $manager->flush();
    }
}
