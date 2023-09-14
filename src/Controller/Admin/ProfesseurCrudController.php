<?php

// src/Controller/Admin/ProfesseurCrudController.php

namespace App\Controller\Admin;

use App\Entity\Professeur;
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

class ProfesseurCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/professeur/print", name="admin_professeur_print")
     */
    public function printProfesseurListAction(Request $request): Response
    {
        $professeurs = $this->entityManager->getRepository(Professeur::class)->findAll();
        // Créez une instance de mPDF
        $mpdf = new Mpdf();
        // Générez le contenu HTML de votre PDF en utilisant une vue Twig
        $html = $this->renderView('admin/professeur/print_professeur.html.twig', ['professeurs' => $professeurs]);
        // Chargez le HTML dans mPDF
        $mpdf->WriteHTML($html);
        // Générez le PDF
        $mpdf->Output('liste_professeurs.pdf', 'I');

        // Créez une réponse Symfony pour le PDF
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="liste_professeurs.pdf"');

        return $response;
    }

    public static function getEntityFqcn(): string
    {
        return Professeur::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, Action::new('printProfesseurList', 'Imprimer la liste des professeurs')
                ->linkToUrl($this->generateUrl('admin_professeur_print')));
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
