<?php
// src/Controller/Admin/NoteEtudiantCrudController.php

namespace App\Controller\Admin;

use App\Entity\NoteEtudiant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Etudiant;
use App\Form\NoteEtudiantType;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Mpdf\Mpdf;

class NoteEtudiantCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/notes-etudiant', name: 'admin_notes_etudiant')]
    public function index(AdminContext $context): Response
    {
        
        $request = $context->getRequest();
    
        $searchForm = new NoteEtudiant();
    $form = $this->createForm(NoteEtudiantType::class, $searchForm);
    $form->handleRequest($request);

    $cne = $searchForm->getCne();

    $etudiant = null;
    $etudiants = [];

    if ($form->isSubmitted() && $form->isValid()) {
        if ($cne !== null) {
            $etudiant = $this->entityManager->getRepository(Etudiant::class)
                ->findOneBy(['cne' => $cne]);
        }
    } else {
        // Si aucun CNE n'est saisi, récupérez tous les étudiants
        $etudiants = $this->entityManager->getRepository(Etudiant::class)->findAll();
    }

    $notesEtudiant = []; // Définissez une valeur par défaut

    if ($etudiant) {
        // Si l'étudiant est trouvé, récupérez ses notes
        $notesEtudiant = $etudiant->getNotes();
    } else {
        // Gérez le cas où l'étudiant n'est pas trouvé
        // ...
    }

    return $this->render('admin/note_etudiant/search.html.twig', [
        'form' => $form->createView(),
        'notesEtudiant' => $notesEtudiant,
        'etudiant' => $etudiant,
        'etudiants' => $etudiants,
    ]);
}   
#[Route('/admin/notes-etudiant/print', name: 'admin_notes_etudiant_print')]
public function printNotesAction(Request $request): Response
{
    // Récupérez l'étudiant par le CNE
    $cne = $request->query->get('cne');
    $etudiant = $this->entityManager->getRepository(Etudiant::class)->findOneBy(['cne' => $cne]);

    // Vérifiez si l'étudiant existe
    if (!$etudiant) {
        throw $this->createNotFoundException('Étudiant non trouvé.');
    }

    // Récupérez les notes de l'étudiant
    $notesEtudiant = $etudiant->getNotes();

    // Créez une instance de mPDF
    $mpdf = new Mpdf();

    // Générez le contenu HTML de votre PDF en utilisant une vue Twig personnalisée
    $html = $this->renderView('admin/note_etudiant/print_notes_etudiant.html.twig', [
        'etudiant' => $etudiant,
        'notesEtudiant' => $notesEtudiant,
    ]);

    // Chargez le HTML dans mPDF
    $mpdf->WriteHTML($html);

    // Générez le PDF
    $mpdf->Output('notes_etudiant.pdf', 'I'); // 'I' signifie que le PDF sera ouvert dans le navigateur

    // Créez une réponse Symfony pour le PDF
    $response = new Response();
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'inline; filename="notes_etudiant.pdf"');

    return $response;
}


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Rechercher des Notes d\'un Étudiant');
    }

    public static function getEntityFqcn(): string
    {
        return NoteEtudiant::class;
    }
}