<?php 
// src/Entity/NoteEtudiant.php

namespace App\Entity;

class NoteEtudiant
{
    private ?string $nom = null;
    private ?string $prenom = null;
    private ?string $cne = null; // Ajoutez la propriété cne


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getCne(): ?string
    {
        return $this->cne;
    }

    public function setCne(?string $cne): void
    {
        $this->cne = $cne;
    }
}
