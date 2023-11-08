<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

;


class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();



        for ($i = 0; $i < 10; $i++) {

            $sortie = new Sortie();

            $sortie->setNom($faker->nom);
            $sortie->setDateHeureDebut($faker->date_heure_debut);
            $sortie->setDateLimiteInscription($faker->data_limite_inscription);
            $sortie->setNbInsciptionMax($faker->nb_insciption_max);
            $sortie->setCampus($this->getReference('campus'));


            $manager->persist($sortie);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
    }
}
