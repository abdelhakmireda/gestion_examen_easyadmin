<?php

// src/Controller/Admin/UserCrudController.php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextBlockField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username', 'Nom d\'utilisateur'),
            EmailField::new('email', 'Email'),
            TextField::new('password', 'Mot de passe'),
              ArrayField::new('roles', 'Rôles')
                ->hideOnForm(),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Professeur' => 'ROLE_PROFESSEUR',
                    'Administrateur' => 'ROLE_ADMIN',
                    
                ])
                ->allowMultipleChoices()
                ->autocomplete(),
            TextField::new('locale', 'Locale'),
            BooleanField::new('isVerified', 'Est vérifié'),
        ];
    }
}




