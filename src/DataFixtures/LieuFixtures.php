<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class LieuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $lieu = new lieu();

            $lieu->setNom($faker->nom);
            $lieu->setrue($faker->rue);
            $lieu->setlatitude($faker->latitude);
            $lieu->setlongitude($faker->longitude);



            $manager->persist($lieu);
        }

        $manager->flush();

    }


}