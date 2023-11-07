<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Form\Model\SortieFiltre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function getWithFilters(SortieFiltre $sortieFiltre){
        $qb = $this->createQueryBuilder('s');

        if($sortieFiltre->getCampus()){
            $qb ->andWhere('s.campus = :campus')->setParameter('campus', $sortieFiltre->getCampus());
        }

        return $qb->getQuery()->getResult();
    }

}
