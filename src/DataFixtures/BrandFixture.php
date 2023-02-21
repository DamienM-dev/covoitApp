<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;



class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = (new \Faker\Factory())::create();

        //$marquesVoiture = ['Toyota', 'Ford', 'Honda', 'Chevrolet', 'BMW', 'Audi', 'Mercedes-Benz', 'Volkswagen', 'Nissan', 'Jeep', 'Kia', 'Hyundai', 'Mazda', 'Subaru', 'Lexus', 'Porsche', 'Ferrari', 'Lamborghini', 'Aston Martin', 'Rolls-Royce'];

        for ($i = 0; $i < 10; $i++) {
            $brand = new Brand();

            $brand->setBrand($faker->vehicleBrand());
            $manager->persist($brand);
        
        }
        $manager->flush();
    }
}

