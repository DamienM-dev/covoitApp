<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\City;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for( (int)$i = 0; $i < 20; $i++) {



            $utilisateur = new User();
            $utilisateur->setLogin("Raphou".$i);
            $utilisateur->setName("Raphaêl".$i);
            $utilisateur->setSurname("Etdonatelo");
            $utilisateur->setEmail("raphoudu56@mail.com");
            $utilisateur->setPassword("MotDePasseIncracable");


        }

        $manager->flush();
    }
}
