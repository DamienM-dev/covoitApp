<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $modelVoiture = ['Camry', 'Mustang', 'Civic', 'Corvette', 'X5', 'A4', 'class-C', 'Golf'];
        $marquesVoiture = ['Toyota', 'Ford', 'Honda', 'Chevrolet', 'BMW', 'Audi', ' Mercedes-Benz', ' Volkswagen', 'Nissan', 'Jeep', 'Kia', 'Hyundai', 'Mazda', 'Subaru', 'Lexus', 'Porsche', 'Ferrari', 'Lamborghini', 'Aston Martin', 'Rolls-Royce'];

        for ((int)$i = 0; $i < 20; $i++) {


            


            //---------- Création des fixtures VOITURE ----------

            $voiture = new Car();




            $voiture->setImmatriculation($i);
            
            $voiture->setBrand($faker->randomElement($marquesVoiture));
            
            $voiture->setModel($faker->randomElement($modelVoiture));
            $voiture->setNbrPlaces($faker->numberBetween(1, 6));

            $manager->persist($voiture);
        }

        $manager->flush();
    }
}
