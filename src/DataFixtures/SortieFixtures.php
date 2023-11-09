<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;




class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $campus = $manager->getRepository(Campus::class)->findAll();
        $members = $manager->getRepository(Participant::class)->findAll();
        $places = $manager->getRepository(Lieu::class)->findAll();
        $etatCree= $manager ->getRepository(Etat::class)->findByLibelle(Etat::CREE);
        $etatPublier= $manager ->getRepository(Etat::class)->findByLibelle(Etat::PUBLIER);

        for ($i = 1; $i <= 15; $i++) {
            $excursion = new Sortie();
            $excursion->setNom($faker->word);
            $dateStart = $faker->dateTimeBetween('-1 months', '+2 months');
            $excursion->setDateHeureDebut($dateStart);
            $excursion->setDuree(mt_rand(30, 240));
            $excursion->setDateLimiteInscription($faker->dateTimeBetween($dateStart,'+2 months'));
            $excursion->setNbInsciptionMax(mt_rand(1, 30));
            $excursion->setInfosSortie($faker->realText());
            $organizerMember = $faker->randomElement($members);
            $excursion->setOrganisateur($organizerMember);
            if ($excursion->getDateHeureDebut()> new \DateTime && $excursion->getDateLimiteInscription()>new \DateTime)
            {
                if (mt_rand(1, 100) <= 30) {
                    $this->addParticipant($excursion);
                }
            }
            $excursion->setCampus($faker->randomElement($campus));

            $excursion->setEtat($faker->randomElement(array($etatCree,$etatPublier)));
            $excursion->setLieu($faker->randomElement($places));
            //Condition for our SpecialMember (30% to be participant of an excursion).

            $manager->persist($excursion);
        }

        $manager->flush();

    }
    public function addParticipant(Sortie $sortie): void {
        for ($i = 0; $i <= mt_rand(0,5); $i++) {
            $participant = $this->getReference('test' . rand (1,9));
            $sortie->addParticipant($participant);
        }
    }


    public function getDependencies(): array
    {
        return [
            LieuFixtures::class,
            UserFixtures::class,
            Campusfixtures::class,
        ];
    }
}

