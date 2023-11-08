<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use app\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    const NB_USER = 10;
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }
    public function load(ObjectManager $manager)
    {
        $campus = $manager->getRepository(Campus::class)->findAll();

        $faker = Factory::create(); // Create a Faker instance
        $admin = new Participant();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNom('admin');
        $admin->setPrenom('admin');
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, '123456'));
        $admin->setActif(true);
        $admin->setMail('omer.cod@gmail.com');
        $admin->setPseudo('admin');
        $manager->persist($admin);

        // Create and persist multiple user data with random values
        for ($i = 0; $i <self::NB_USER; $i++) {
            $user = new Participant();
            $user->setRoles(['ROLE_USER']);
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, '123456'));
            $user->setActif(true);
            $user->setMail($faker->email);
            $user->setPseudo($faker->userName);
            $user->setCampus($faker->randomElement($campus));
            $user->setTelephone($faker->phoneNumber);
            $this->addReference('test'.$i, $user);

            $manager->persist($user);
        }
        $this->addReference('organizerAdmin', $admin);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            Campusfixtures::class,
        ];
    }

}
