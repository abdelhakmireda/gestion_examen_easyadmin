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
use Dompdf\Dompdf;
use Dompdf\Options;

class EtudiantCrudController extends AbstractCrudController
{
    private $entityManager;
    private $dompdf;

    public function __construct(EntityManagerInterface $entityManager, Dompdf $dompdf)
    {
        $this->entityManager = $entityManager;
        $this->dompdf = $dompdf;
    }

    /**
     * @Route("/admin/etudiant/print", name="admin_etudiant_print")
     */
    public function printStudentListAction(Request $request): Response
    {
        $etudiants = $this->entityManager->getRepository(Etudiant::class)->findAll();

        $html = $this->renderView('admin/etudiant/print_list.html.twig', ['etudiants' => $etudiants]);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        $pdfContent = $this->dompdf->output();
        return new Response($pdfContent, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="liste_etudiants.pdf"',
        ]);
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
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            TextField::new('contact'),
            ImageField::new('photo')
                ->setBasePath('uploads/images/etudiants')
                ->setUploadDir('public/uploads/images/etudiants')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('filliere'),
        ];
    }
}
