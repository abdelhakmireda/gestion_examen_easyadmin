<?php

// src/Controller/Admin/ProfesseurCrudController.php

namespace App\Controller\Admin;

use App\Repository\ProfesseurRepository;
use App\Entity\Professeur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ProfesseurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Professeur::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
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
