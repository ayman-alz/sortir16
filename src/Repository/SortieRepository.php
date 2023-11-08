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
    public function __construct(ManagerRegistry $registry, private Security $security)
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
            $qb ->andWhere('s.organisateur = :organisateur') ->setParameter('organisateur' , $this->security->getUser());
        }

       if ($sortieFiltre ->getInscrit()) {
           $qb ->andWhere(':inscrit MEMBER OF s.participants') ->setParameter('inscrit' , $this ->security ->getUser());
       }
        if ($sortieFiltre ->getNoninscrit()) {
            $qb ->andWhere(':noninscrit NOT MEMBER OF s.participants') ->setParameter('noninscrit' , $this ->security ->getUser());
        }
        if ($sortieFiltre->getSoireepasse()) {
            $qb->join('s.etat', 'e') ->andWhere('e.libelle = :etatLibelle') ->setParameter('etatLibelle', 'passée');
        }



        return $qb->getQuery()->getResult();
    }

}
