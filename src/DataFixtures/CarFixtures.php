<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
  
        

        for( (int)$i = 0; $i < 20; $i++) {

        

            //---------- Création des fixtures VOITURE ----------
        
            $voiture = new Car();


            $voiture->setImmatriculation($i);
            $voiture->setBrand("alpine");
            $voiture->setModel("A110");
            $voiture->setNbrPlaces(4);

            $manager->persist($voiture);
       
        }

        $manager->flush();
    }
}
