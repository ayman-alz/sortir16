<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $ville = new lieu();

            $ville->setNom($faker->nom);
            $ville->setcode_postal($faker->code_postal);

            $manager->flush();
        }
        $manager->flush();
    }
}
