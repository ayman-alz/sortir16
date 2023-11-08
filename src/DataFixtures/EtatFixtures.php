<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtatFixtures extends Fixture

{
    public function load(ObjectManager $manager): void
    {
        $etatArray = array(Etat::CREE,Etat::PUBLIER,Etat::ACTIVE,Etat::PASSE,Etat::TERMINE,Etat::ANNULE);
        $iMax = count($etatArray);
        for ($i = 0 ; $i < $iMax; $i++){
            $etat = new Etat();
            $etat->setLibelle($etatArray[$i]);
            $manager->persist($etat);
        }
        $manager->flush();
    }


}