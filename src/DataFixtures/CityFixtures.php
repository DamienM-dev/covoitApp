<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for( (int)$i = 0; $i < 20; $i++) {


        //---------- Création des fixtures VILLE ----------

            $ville = new City();
            $ville->setName($faker->city());
            $ville->setCp('5600'.$i);
            $ville->setLongitude('10'.$i);
            $ville->setLatitude('10'.$i);

            $manager->persist($ville);


        
        }

        $manager->flush();
    }
}
