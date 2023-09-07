<?php
// src/Controller/Admin/NoteCrudController.php

namespace App\Controller\Admin;

use App\Entity\Note;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField; // Utilisez NumberField au lieu de FloatField
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField; // Ajoutez ChoiceField

class NoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Note::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $mentionChoices = [ // Définissez les choix pour la mention
            'Passable' => 'Passable',
            'Assez-bien' => 'Assez-bien',
            'Bien' => 'Bien',
            'Très-bien' => 'Très-bien',
            'Excellent' => 'Excellent',
        ];

        return [
            IntegerField::new('valeur')->setLabel('Note'), // Renommez le champ en "Note"
            ChoiceField::new('mention')->setChoices($mentionChoices), // Utilisez ChoiceField pour la mention
            TextField::new('description')->hideOnIndex(),
            AssociationField::new('etudiant'),
            AssociationField::new('module'),
        ];
    }
}
