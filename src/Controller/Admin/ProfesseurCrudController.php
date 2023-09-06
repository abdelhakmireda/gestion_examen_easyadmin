<?php

// src/Controller/Admin/ProfesseurCrudController.php

namespace App\Controller\Admin;

use App\Entity\Professeur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ProfesseurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Professeur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            TextField::new('cni'),
            TextField::new('contact'),
            ImageField::new('photo')
                ->setBasePath('uploads/images/professeurs')
                ->setUploadDir('public/uploads/images/professeurs')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('modules'),

        ];
    }
}
