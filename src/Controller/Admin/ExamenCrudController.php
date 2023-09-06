<?php

// src/Controller/Admin/ExamenCrudController.php
namespace App\Controller\Admin;

use App\Entity\Examen;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ExamenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Examen::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [ 
            TextField::new('titre', 'titre '),
            AssociationField::new('module', 'Module'),
            DateField::new('date', 'Date de l\'examen'),
            IntegerField::new('duree', 'Durée de l\'examen')
                ->setHelp('La durée en minutes'),
            ChoiceField::new('heure', 'Heure de l\'examen')
                ->setChoices([
                    '08:00' => '08:00',
                    '10:00' => '10:00',
                    '14:00' => '14:00',
                ]),
            ChoiceField::new('session', 'Session')
                ->setChoices([
                    'Normale' => 'Normale',
                    'Rattrapage' => 'Rattrapage',
                ]),
            TextField::new('description', 'Description'),
            TextField::new('classe', 'Classe'),
            AssociationField::new('professeur', 'Professeur')
                
        ];
    }
}


