<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Form\Model\SortieFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,private Security $security)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function getWithFilters(SortieFilter $sortieFiltre){
        $qb = $this->createQueryBuilder('s');

        if($sortieFiltre->getCampus()){
            $qb ->andWhere('s.campus = :campus')->setParameter('campus', $sortieFiltre->getCampus());
        }

        if ($sortieFiltre -> getNom()) {
            $qb -> andWhere('s.nom = :nom') ->setParameter('nom' , $sortieFiltre ->getNom() );
        }
        if ($sortieFiltre->getDateHeureDebut()) {
            $qb ->andWhere('s.dateHeureDebut = :date_heure_debut') ->setParameter('date_heure_debut' , $sortieFiltre ->getDateHeureDebut() ) ;
        }
        if ($sortieFiltre ->getDataLimiteInscription()) {
            $qb ->andWhere('s.dateLimiteInscription = :date_limite_inscription') ->setParameter('date_limite_inscription' , $sortieFiltre ->getDataLimiteInscription()) ;
        }
        if ($sortieFiltre ->getOrganisateur()) {
            $qb ->andWhere('s.organisateur = :organisateur') ->setParameter('organisateur' , $this->security->getUser() );
        }
        

    /*    if ($sortieFiltre->getInscrit()) {
            $qb
                ->andWhere(':member MEMBER OF e.participants')
                ->setParameter('member', $member);
        }

        if ($filterModel->isNotRegistred()) {
            $queryBuilder
                ->andWhere(':member NOT MEMBER OF e.participants')
                ->setParameter('member', $member);
        }

        $finishedState = $this->stateRepository->findOneBy(['caption' => 'Finished']);
        if($filterModel->isFinished()){
            $queryBuilder
                ->andWhere('e.state = :finishedState')
                ->setParameter("finishedState", $finishedState);
        }
*/




        return $qb->getQuery()->getResult();
    }
//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
