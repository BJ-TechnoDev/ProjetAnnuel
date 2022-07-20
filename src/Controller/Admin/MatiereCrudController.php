<?php

namespace App\Controller\Admin;

use App\Entity\Matiere;
use App\Service\CsvService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\File;

class MatiereCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Matiere::class;
    }

    private CsvService $csvService;

    public function __construct(CsvService $csvService, EntityManagerInterface $em)
    {
        $this->csvService = $csvService;
        $this->entityManager = $em;

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')
                ->setLabel('Nom de la matière')
                ->setColumns('col-6'),
            ChoiceField::new('semestre')
                ->setChoices([
                    'Semestre 1' => 'Semestre 1',
                    'Semestre 2' => 'Semestre 2'
                ])
                ->setColumns('col-6'),
            TextField::new('volume_heure')
                ->setLabel('Volume Horaire')
                ->setColumns('col-6'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $export = Action::new('export', 'Export')
            ->setIcon('fa fa-download')
            ->linkToCrudAction('export')
            ->setCssClass('btn')
            ->createAsGlobalAction();

        $import = Action::new('import', 'Import')
            ->setIcon('fa fa-file-import')
            ->linkToCrudAction('import')
            ->setCssClass('btn')
            ->createAsGlobalAction();


        return $actions


            // ...
//            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $export)
            ->add(Crud::PAGE_INDEX, $import)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER);

    }

    public function export(Request $request)
    {
        $context = $request->attributes->get(EA::CONTEXT_REQUEST_ATTRIBUTE);
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $contrats = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters)
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($contrats as $contrat) {
            $data[] = $contrat->getExportDataMatiere();
        }

        return $this->csvService->export($data, 'export_matiere_' . date_create()->format('d-m-y') . '.csv');
    }

    public function import(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createFormBuilder()
            ->add('ImportMatiere', FileType::class, [
                'required' => true,
                'label' => 'Import Ficher CSV',
                'constraints' => [
                    new File([
                        'mimeTypes' => [ // We want to let upload only txt, csv or Excel files
                            'text/x-comma-separated-values',
                            'text/comma-separated-values',
                            'text/x-csv',
                            'text/csv',
                            'text/plain',
                            'application/octet-stream',
                            'application/vnd.ms-excel',
                            'application/x-csv',
                            'application/csv',
                            'application/excel',
                            'application/vnd.msexcel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ],
                        'mimeTypesMessage' => "This document isn't valid.",
                    ])
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Importer',
                'attr' => ['class' => 'btn btn-primary']
            ])// We could have added it in the view, as stated in the framework recommendations
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile */
            $file = $form->get('ImportMatiere')->getData();

            //open file
            $em = $this->entityManager;

            if (($handle = fopen($file->getPathname(), "r")) !== false) {
                $count = 0;
                $batchSize = 1000;
                $data = fgetcsv($handle, 0, ",");

                while (($data = fgetcsv($handle, 0, ',')) !== false) {
                    $count++;
                    $entity = new Matiere();


                    $entity->setNom($data[0]);
                    $entity->setSemestre($data[1]);
                    $entity->setVolumeHeure($data[2]);


                    $em->persist($entity);

                    if (($count % $batchSize) === 0) {
                        $em->flush();
                        $em->clear();
                    }
                }
                $this->addFlash('success', 'Votre Import a été effectué avec succès!');

                fclose($handle);
                $em->flush();
                $em->clear();
            } else {
                $this->addFlash('danger', 'Votre Import a échoué!');
            }
        }

        return $this->render("admin/import.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
