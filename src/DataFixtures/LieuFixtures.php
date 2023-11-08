<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class LieuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $villes = $manager->getRepository(Ville::class)->findAll();

        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {

            $lieu = new Lieu();
            $lieu->setNom($faker->nom);
            $lieu->setrue($faker->rue);
            $lieu->setlatitude($faker->latitude);
            $lieu->setlongitude($faker->longitude);
            $lieu->setVille($faker->randomElement($villes));

            $manager->persist($lieu);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            VilleFixtures::class,
        ];
    }

}