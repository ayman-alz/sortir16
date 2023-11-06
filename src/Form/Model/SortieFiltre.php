<?php

namespace App\Form\Model;

use App\Entity\Campus;
use phpDocumentor\Reflection\Types\Integer;

class SortieFiltre
{



    private ?Campus $campus;

    private string $nom ;


    private \DateTime $date_heure_debut ;

    private \DateTime $data_limite_inscription ;

    public function getCampusId(): string
    {
        return $this->campus_id;
    }

    public function setCampusId(string $campus_id): void
    {
        $this->campus_id = $campus_id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDateHeureDebut(): \DateTime
    {
        return $this->date_heure_debut;
    }

    public function setDateHeureDebut(\DateTime $date_heure_debut): void
    {
        $this->date_heure_debut = $date_heure_debut;
    }

    public function getDataLimiteInscription(): \DateTime
    {
        return $this->data_limite_inscription;
    }

    public function setDataLimiteInscription(\DateTime $data_limite_inscription): void
    {
        $this->data_limite_inscription = $data_limite_inscription;
    }

}