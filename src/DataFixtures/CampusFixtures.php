<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $campus = new Campus();
        $campus->setnom('Rennes');


        $manager->persist($campus);

        $manager->flush();
    }
}
