<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $brands = $manager->getRepository(Brand::class)->findAll();
   
    
        for ($i = 0; $i < 20; $i++) {
            $car = new Car();
            $randBrand = $brands[array_rand($brands)];
            $car->setImmatriculation($faker->randomNumber(2, 5, true));
            $car->setNbrPlaces($faker->numberBetween(1, 6));
            $car->setTypeOf($randBrand);
    
            $manager->persist($car);
        }
    
        $manager->flush();
    }
}
