<?php

// src/Controller/Admin/FilliereCrudController.php

namespace App\Controller\Admin;

use App\Entity\Filliere;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class FilliereCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Filliere::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Filières')
            ->setEntityLabelInSingular('Filière')
            ->setEntityLabelInPlural('Filières')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom de la Filière'),
            AssociationField::new('etudiants', 'Étudiants'),
            AssociationField::new('module', 'Modules'),
        ];
    }
}
