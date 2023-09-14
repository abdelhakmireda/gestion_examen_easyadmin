<?php

// src/Controller/Admin/EtudiantCrudController.php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Mpdf\Mpdf;  // Importez la classe Mpdf

class EtudiantCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/etudiant/print", name="admin_etudiant_print")
     */
    
    public function printStudentListAction(Request $request): Response
    {
        $etudiants = $this->entityManager->getRepository(Etudiant::class)->findAll();
        // Créez une instance de mPDF
        $mpdf = new Mpdf();
        // Générez le contenu HTML de votre PDF en utilisant une vue Twig
        $html = $this->renderView('admin/etudiant/print_etudiant.html.twig', ['etudiants' => $etudiants]);
        // Chargez le HTML dans mPDF
        $mpdf->WriteHTML($html);
        // Générez le PDF
        $mpdf->Output('liste_etudiants.pdf', 'I');
    
        // Créez une réponse Symfony pour le PDF
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="liste_etudiants.pdf"');

        return $response;
    }

    public static function getEntityFqcn(): string
    {
        return Etudiant::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, Action::new('printStudentList', 'Imprimer la liste des étudiants')
                ->linkToUrl($this->generateUrl('admin_etudiant_print')));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('cne'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            ImageField::new('photo')
                ->setBasePath('uploads/images/etudiants')
                ->setUploadDir('public/uploads/images/etudiants')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('filliere'),
        ];
    }
}
