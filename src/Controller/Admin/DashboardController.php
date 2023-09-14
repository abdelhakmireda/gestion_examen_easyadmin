<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Entity\Examen;
use App\Entity\Filliere;
use App\Entity\Module;
use App\Entity\Note;
use App\Entity\Professeur;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\Security\Core\User\UserInterface;


class DashboardController extends AbstractDashboardController
{
    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $etudiantRepository = $this->entityManager->getRepository(Etudiant::class);
        $professeurRepository = $this->entityManager->getRepository(Professeur::class);
        $moduleRepository = $this->entityManager->getRepository(Module::class);
        $filliereRepository = $this->entityManager->getRepository(Filliere::class);
        $examenRepository = $this->entityManager->getRepository(Examen::class);
        $noteRepository = $this->entityManager->getRepository(Note::class);

        $nombreEtudiants = count($etudiantRepository->findAll());
        $nombreProfesseurs = count($professeurRepository->findAll());
        $nombreModules = count($moduleRepository->findAll());
        $nombreFillieres = count($filliereRepository->findAll());
        $nombreExamens = count($examenRepository->findAll());
        $nombreNotes = count($noteRepository->findAll());

        return $this->render('admin/dashboard.html.twig', [
            'nombreEtudiants' => $nombreEtudiants,
            'nombreProfesseurs' => $nombreProfesseurs,
            'nombreModules' => $nombreModules,
            'nombreFillieres' => $nombreFillieres,
            'nombreExamens' => $nombreExamens,
            'nombreNotes' => $nombreNotes,
        ]);
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion D Examen');
    }
     
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUserIdentifier())
            ->setGravatarEmail($user->getEmail())
         //   ->setAvatarUrl('https://www.clipartmax.com/png/full/405-4050774_avatar-icon-flat-icon-shop-download-free-icons-for-avatar-icon-flat.png')
            ->displayUserAvatar(true);
    }



    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('build/css/admin.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('etudiant', 'fas fa-user-graduate', Etudiant::class);
        yield MenuItem::linkToCrud('Professeur', 'fas fa-chalkboard-teacher', Professeur::class);
        yield MenuItem::linkToCrud('examen', 'fas fa-file-alt', Examen::class);
        yield MenuItem::linkToCrud('Filliere', 'fas fa-university', Filliere::class);
        yield MenuItem::linkToCrud('Module', 'fas fa-book', Module::class);
        yield MenuItem::linkToCrud('Note', 'fas fa-sticky-note', Note::class);
        yield MenuItem::linkToCrud('user', 'fas fa-sticky-note', User::class);
        yield MenuItem::section('Gestion des Étudiants', 'fas fa-graduation-cap')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToRoute('Rechercher des Notes d\'un Étudiant', 'fas fa-search', 'admin_notes_etudiant');

    }
}

  