<?php
// src/Controller/Admin/NoteCrudController.php

namespace App\Controller\Admin;

use App\Entity\Note;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField; // Utilisez NumberField au lieu de FloatField
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class NoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Note::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            NumberField::new('valeur'),
            TextField::new('mention'),
            TextField::new('description')->hideOnIndex(),
            AssociationField::new('etudiant'),
            AssociationField::new('module'),
        ];
    }
}
