<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Entity\Examen;
use App\Entity\Filliere;
use App\Entity\Module;
use App\Entity\Note;
use App\Entity\Professeur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


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

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('etudiant', 'fas fa-user-graduate', Etudiant::class);
        yield MenuItem::linkToCrud('Professeur', 'fas fa-chalkboard-teacher', Professeur::class);
        yield MenuItem::linkToCrud('examen', 'fas fa-file-alt', Examen::class);
        yield MenuItem::linkToCrud('Filliere', 'fas fa-university', Filliere::class);
        yield MenuItem::linkToCrud('Module', 'fas fa-book', Module::class);
        yield MenuItem::linkToCrud('Note', 'fas fa-sticky-note', Note::class);
        
    }
}

  