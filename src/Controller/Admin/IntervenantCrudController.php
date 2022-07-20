<?php

namespace App\Controller\Admin;

use App\Entity\Intervenant;
use App\Service\CsvService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\File;

class IntervenantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Intervenant::class;
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
            TextField::new('Nom')
                ->setLabel('Nom de famille')
                ->setRequired(true)
                ->setColumns('col-6'),
            TextField::new('Prenom')
                ->setLabel('Prénom')
                ->setRequired(true)
                ->setColumns('col-6'),
            EmailField::new('Email')
                ->setLabel('Adresse e-mail')
                ->setRequired(true)
                ->setColumns('col-6'),
            TelephoneField::new('Telephone')
                ->setLabel('Numéro de Téléphone')
                ->setRequired(true)
                ->setColumns('col-6'),
            TextField::new('Adresse')
                ->setLabel('Adresse postale')
                ->setRequired(true)
                ->setColumns('col-12'),
            ChoiceField::new('Roles')
                ->setLabel('Entrez le role')
                ->autocomplete()
                ->setColumns('col-6')
                ->setChoices([
                    'Intervenant' => 'Intervenant',
                ]),
            TextField::new('societe')
                ->setLabel('Societe')
                ->setRequired(true)
                ->setColumns('col-6'),
            TelephoneField::new('numero_contact')
                ->setLabel('Numero de contact')
                ->setRequired(true)
                ->setColumns('col-6'),
            EmailField::new('mail_contact')
                ->setLabel('Mail de contact')
                ->setRequired(true)
                ->setColumns('col-6'),
            TextField::new('type_societe')
                ->setLabel('Type de societe')
                ->setRequired(true)
                ->setColumns('col-6'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the visible title at the top of the page and the content of the <title> element
            // it can include these placeholders:
            //   %entity_name%, %entity_as_string%,
            //   %entity_id%, %entity_short_id%
            //   %entity_label_singular%, %entity_label_plural%
            ->setPageTitle('index', '%entity_label_plural% liste')
            ->setHelp('index', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            ->setHelp('new', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            ->setHelp('edit', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            ->setHelp('detail', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            //   %entity_label_singular%, %entity_label_plural%

            // you can pass a PHP closure as the value of the title
            ->setPageTitle('new', 'Créer un Intervenant')

            // in DETAIL and EDIT pages, the closure receives the current entity
            // as the first argument
            // the help message displayed to end users (it can contain HTML tags)
            ->setPageTitle('edit', 'Modifier un Intervenant')
            ;
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

    public function export(Request $request){
        $context = $request->attributes->get(EA::CONTEXT_REQUEST_ATTRIBUTE);
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $contrats = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters)
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($contrats as $contrat) {
            $data[] = $contrat->getExportDataIntervenant();
        }

        return $this->csvService->export($data, 'export_intervenant_' . date_create()->format('d-m-y') . '.csv');
    }

    public function import(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createFormBuilder()
            ->add('ImportIntervenant', FileType::class, [
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
            $file = $form->get('ImportIntervenant')->getData();

            //open file
            $em = $this->entityManager;

            if (($handle = fopen($file->getPathname(), "r")) !== false) {
                $count = 0;
                $batchSize = 1000;
                $data = fgetcsv($handle, 0, ",");

                while (($data = fgetcsv($handle, 0, ',')) !== false) {
                    $count++;
                    $entity = new Intervenant();


                    $entity->setNom($data[0]);
                    $entity->setPrenom($data[1]);
                    $entity->setEmail($data[2]);
                    $entity->setTelephone($data[3]);
                    $entity->setAdresse($data[4]);
                    $entity->setRoles($data[5]);
                    $entity->setSociete($data[6]);
                    $entity->setNumeroContact($data[7]);
                    $entity->setMailContact($data[8]);
                    $entity->setTypeSociete($data[9]);


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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('Nom')
            ->add('Email');
    }


}
