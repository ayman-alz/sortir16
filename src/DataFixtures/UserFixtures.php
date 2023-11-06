<?php

namespace App\DataFixtures;

use app\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(); // Create a Faker instance

        // Create and persist multiple user data with random values
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setPseudo($faker->pseudo);
            $user->setNom($faker->nom);
            $user->setadministrateur(true);
            $user->setPrenom($faker->prenom);
            $user->setTelephone($faker->telephone);
            $user->setMail($faker->mail);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
