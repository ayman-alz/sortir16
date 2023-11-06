<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class SortieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $sortie = new Sortie();

            $sortie->setNom($faker->nom);
            $sortie->setdate_heure_debut($faker->date_heure_debut);
            $sortie->setdata_limite_inscription($faker->data_limite_inscription);
            $sortie->setTelephone($faker->telephone);
            $sortie->setnb_insciption_max($faker->nb_insciption_max);
            $sortie->setinfos_sortie($faker->infos_sortie);


            $manager->persist($sortie);
        }

        $manager->flush();

    }
}
