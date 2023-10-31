<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Participant;
use Faker;

class Members extends Fixture
{

  public function load(ObjectManager $manager): void
  {
      $faker = Faker\Factory::create('fr_FR');
      foreach (range(0, 10) as $item){
          $participant = new Participant();
          $participant
              -> setNom($faker->firstName)
              ->setMail($faker->email)
              ->setMotPasse($faker ->password)
              ->setPrenom($faker ->lastName)
              ->setAdministrateur(false)
              ->setActif(true)
              ->setTelephone($faker ->phoneNumber)
              ->setIdCampus(1);
          $manager->persist($participant);
      }
      $manager->flush();
  }

}
