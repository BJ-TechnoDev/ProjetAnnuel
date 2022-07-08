<?php

namespace App\Controller\Admin;

use App\Entity\Contrat;
use App\Entity\Intervenant;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class IntervenantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Intervenant::class;
    }

    private CsvService $csvService;

    public function __construct(CsvService $csvService, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer){
        $this->csvService = $csvService;
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
                ->setColumns('col-12')
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

            // you can pass a PHP closure as the value of the title
            ->setPageTitle('new', 'Créez un Intervenant')

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

        $exportContratCasparCas = Action::new('exportContrat');

        return $actions


            // ...
//            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $export)
            ->add(Crud::PAGE_INDEX, $import)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->addBatchAction(Action::new($exportContratCasparCas, 'Exporter')
                ->linkToCrudAction('exportContrat')
                ->addCssClass('btn')
                ->setIcon('fa fa-download'))
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE);
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

    public function exportContrat(Contrat $contrat)
    {
        return [
            'id' => $contrat->getId(),
        ];
    }

    public function import(Request $request, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
        $contrats = $this->csvService->import($request->files->get('csv')->getPathname());

        foreach ($contrats as $contrat) {
            // Denormalizes data back into an Order object
            $entity = $denormalizer->denormalize($contrats, Contrat::class);
            // Then validate the entity and persist it if there's no validation error
            // ...
        }

        $entityManager->flush();

    }

}
