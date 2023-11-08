<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class Campusfixtures extends Fixture

{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(); // Create a Faker instance

        for ($i = 0; $i < 10; $i++) {
            $campus = new Campus();
            $campus->setnom($faker->city);
            $manager->persist($campus);

        }

        $manager->flush();
    }


}
