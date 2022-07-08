<?php

namespace App\Controller\Admin;

use App\Entity\Contrat;
use App\Service\CsvService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Select;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ContratCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Contrat::class;
    }

    private CsvService $csvService;

    public function __construct(CsvService $csvService, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer){
        $this->csvService = $csvService;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('dateDemande')
                ->setLabel('Date Demande')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('marqueOuEcole')
                ->setLabel('Marque / Ecole')
                ->setRequired(true)
                ->setColumns('col-4'),
            AssociationField::new("intervenant")
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('typeSociete')
                ->setLabel('Société')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('commentaire')
                ->setLabel('Commentaires')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('statusContrat')
                ->setLabel('Statut Contrat')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('typeMission')
                ->setLabel('Type de Mission')
                ->setRequired(true)
                ->setColumns('col-4'),
            NumberField::new('tarif')
                ->setLabel('Tarif à appliquer (€)')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('horaire')
                ->setLabel('Horaire ou Forfait')
                ->setRequired(true)
                ->setColumns('col-4'),
            ChoiceField::new('ttcSst')
                ->setLabel('TTC/SST')
                ->setRequired(true)
                ->setChoices([
                    'TTC' => 'TTC',
                    'SST' => 'SST'
                ])
                ->setColumns('col-4'),
            NumberField::new('volumeHoraire')
                ->setLabel('Volume Horaire')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('unite')
                ->setLabel('Unite')
                ->setRequired(true)
                ->setColumns('col-4'),
            DateField::new('dateDebut')
                ->setLabel('Date Début')
                ->setRequired(true)
                ->setColumns('col-4'),
            DateField::new('dateFin')
                ->setLabel('Date Fin')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('matiere')
                ->setLabel('Matière')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('promotion')
                ->setLabel('Promotion')
                ->setRequired(true)
                ->setColumns('col-4'),
            ChoiceField::new('alternant')
                ->setLabel('Alternant/Initial')
                ->autocomplete()
                ->setChoices([
                    'Alternant' => 'Alternant',
                    'Initial' => 'Initial'
                ])
                ->setColumns('col-4'),
            NumberField::new('periode')
                ->setLabel('Période')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('rp')
                ->setLabel('RP')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('typeRecrutement')
                ->setLabel('Type Recrutement')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('DiplomeLePlusEleve')
                ->setLabel('Diplôme le plus élevé')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('domaineCompetence1')
                ->setLabel('Domaine de Compétence Principal')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('domaineCompetence2')
                ->setLabel('Domaine de Compétence 2')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('domaineCompetence3')
                ->setLabel('Domaine de Compétence 3')
                ->setRequired(true)
                ->setColumns('col-4'),
            NumberField::new('niveauExpertisePedagogique')
                ->setLabel('Niveau d\'Expertise en Pédagogique')
                ->setRequired(true)
                ->setColumns('col-4'),
            NumberField::new('niveauExpertisePro')
                ->setLabel('Niveau d\'Expertise Matière Professionnelle')
                ->setRequired(true)
                ->setColumns('col-4'),
            ChoiceField::new('etat')
                ->setLabel('Etat (Valeur actuelle)')
                ->autocomplete()
                ->setChoices([
                    'RH en cours de traitement' => 'RH en cours de traitement',
                    'RH dossier complet mais à traiter' => 'RH dossier complet mais à traiter',
                    'Contrat à faire - dossier complet' => 'Contrat à faire - dossier complet',
                    'Attente documents' => 'Attente documents',
                    'Ecart GP' => 'écart GP',
                    'Annulé' => 'Annulé',
                    'Fait' => 'Fait',
                    'Envoyé' => 'Envoyé',
                    'Signé' => 'Signé',
                ])
                ->setColumns('col-4'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% liste')
            ->setPageTitle('new', 'Créez un Contrat')
            ->setPageTitle('edit', 'Modifier un Contrat');
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

                ->add(Crud::PAGE_INDEX, $export)
                ->add(Crud::PAGE_INDEX, $import)
                ->add(Crud::PAGE_INDEX, Action::DETAIL)

                ->addBatchAction(Action::new($exportContratCasparCas,'Exporter')
                ->linkToCrudAction('exportContrat')
                ->addCssClass('btn')
                ->setIcon('fa fa-download'))

                ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
                ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

                ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action){
                    return $action->setLabel('Detail');
                })
                ->update(Crud::PAGE_INDEX, Action::BATCH_DELETE, function (Action $action){
                    return $action->setLabel('Supprimer');
                })
                ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action){
                    return $action->setLabel('Modifier');
                })
                ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){
                    return $action->setLabel('Supprimer');
                })
                ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action){
                    return $action->setLabel('Retour à la liste');
                })
                ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action){
                    return $action->setLabel('Supprimer');
                })
                ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action){
                    return $action->setLabel('Editer');
                })
                ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                    return $action->setLabel('Créer');
                })
                ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                    return $action->setLabel('Ajouter un Contrat');
                })
                ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                    return $action->setLabel('Sauvegarder les changements');
                });
    }

    public function export(Request $request){
        $context = $request->attributes->get(EA::CONTEXT_REQUEST_ATTRIBUTE);
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $contrats = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters)
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($contrats as $contrat){
            $data[] = $contrat->getExportData();
        }

        return $this->csvService->export($data, 'export_contrats_'.date_create()->format('d-m-y').'.csv');
    }

    public function exportContrat(Request $request){
        $context = $request->attributes->get(EA::CONTEXT_REQUEST_ATTRIBUTE);
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $contrats = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters)
            ->getQuery()
            ->getResult();
        $data = [];
        if (Action::TYPE_BATCH){

            foreach ($contrats as $contrat){
                $data[] = $contrat->getExportData();
            }
        }
        return $this->csvService->export($data, 'export_cas_contrat'.date_create()->format('d-m-y').'.csv');

    }

    public function import(Request $request, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer){
        $contrats = $this->csvService->import($request->files->get('csv')->getPathname());

        foreach ($contrats as $contrat) {
            // Denormalizes data back into an Order object
            $entity = $denormalizer->denormalize($contrats, Contrat::class);
            // Then validate the entity and persist it if there's no validation error
            // ...
        }

        $entityManager->flush();

    }


//    #[Route('contrat-request/{contratRequest}', name: 'app_csv_export_contrat_request')]
//    #[ParamConverter("contratRequest", class: Contrat::class)]
//
//    public function contrat_request_export(Contrat $contrat, CsvService $csvService) {
//        $response = new Response($csvService->export($contrat, 'test'));
//        $response->headers->set('Content-Type', 'text/csv');
//        $response->headers->set('Content-Disposition', 'attachment');
//
//        return $response;
//    }

public function configureFilters(Filters $filters): Filters
{
    return $filters
        ->add('etat')
        ->add('intervenant')
        ;
}


}
