<?php

namespace App\Form\Model;

use App\Entity\Campus;


class SortieFilter
{

    private ?Campus $campus = null;

    private ?string $nom = null;


    private ?\DateTime $date_heure_debut = null;

    private ?\DateTime $data_limite_inscription = null;


    private ?bool $organisateur = null;

    private ?bool $inscrit = null;

    private ?bool $noninscrit = null;

    private ?bool $soireepasse = null;



    public function getNoninscrit(): ?bool
    {
        return $this->noninscrit;
    }

    public function setNoninscrit(?bool $noninscrit): void
    {
        $this->noninscrit = $noninscrit;
    }

    public function getSoireepasse(): ?bool
    {
        return $this->soireepasse;
    }

    public function setSoireepasse(?bool $soireepasse): void
    {
        $this->soireepasse = $soireepasse;
    }

    public function getOrganisateur(): ?bool
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?bool $organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    public function getInscrit(): ?bool
    {
        return $this->inscrit;
    }

    public function setInscrit(?bool $inscrit): void
    {
        $this->inscrit = $inscrit;
    }


    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): void
    {
        $this->campus = $campus;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDateHeureDebut(): ?\DateTime
    {
        return $this->date_heure_debut;
    }

    public function setDateHeureDebut(?\DateTime $date_heure_debut): void
    {
        $this->date_heure_debut = $date_heure_debut;
    }

    public function getDataLimiteInscription(): ?\DateTime
    {
        return $this->data_limite_inscription;
    }

    public function setDataLimiteInscription(?\DateTime $data_limite_inscription): void
    {
        $this->data_limite_inscription = $data_limite_inscription;
    }

}
