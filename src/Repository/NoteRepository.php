<?php

// src/Repository/NoteRepository.php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    // Créez une méthode de recherche personnalisée pour rechercher les notes par nom et prénom
    public function findNotesByNomPrenom($nom, $prenom)
    {
        return $this->createQueryBuilder('n')
            ->leftJoin('n.etudiant', 'e')
            ->where('e.nom = :nom')
            ->andWhere('e.prenom = :prenom')
            ->setParameter('nom', $nom)
            ->setParameter('prenom', $prenom)
            ->getQuery()
            ->getResult();
    }
}
