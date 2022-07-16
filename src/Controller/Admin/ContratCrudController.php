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
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\File;
use function Symfony\Component\String\u;

class ContratCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Contrat::class;
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
           AssociationField::new('matiere')
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
            ->setHelp('index', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            ->setHelp('new', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            ->setHelp('edit', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            ->setHelp('detail', 'N\'hésitez pas à consulter la documentation présente dans l\'onglet <strong>Accueil</strong>')
            ->setPageTitle('index', '%entity_label_plural% liste')
            ->setPageTitle('new', 'Créer un Contrat')
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
                ->linkToCrudAction('process')
                ->setCssClass('btn')
                ->createAsGlobalAction();

            return $actions
                ->add(Crud::PAGE_INDEX, $export)
                ->add(Crud::PAGE_INDEX, $import)
                ->add(Crud::PAGE_INDEX, Action::DETAIL)

                ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
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
            $data[] = $contrat->getExportData();
        }

        return $this->csvService->export($data, 'export_contrats_' . date_create()->format('d-m-y') . '.csv');
    }


    public function process(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createFormBuilder()
            ->add('Import', FileType::class, [
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
            $file = $form->get('Import')->getData();

            //open file
            $em = $this->entityManager;

            if (($handle = fopen($file->getPathname(), "r")) !== false) {
                $count = 0;
                $batchSize = 1000;
                $data = fgetcsv($handle, 0, ",");

                while (($data = fgetcsv($handle, 0, ",")) !== false) {
                    $count++;
                    $entity = new Contrat();
                    $test1 = $data[2];
                    $intervenant = u($test1)->split(' ');
                    $findintervenant = $em->getRepository(Intervenant::class)->findBy([
                        'Nom' => $intervenant[0],
                        'Prenom' => $intervenant[1]
                    ]);
                    $matiere = $em->getRepository(Contrat::class)->find($data[14]);
//                    $intervenant = $em->getRepository(Contrat::class)->find($data[2]);


                    $entity->setDateDemande(new \DateTime($data[0]));
                    $entity->setMarqueOuEcole($data[1]);
                    $entity->setIntervenant($findintervenant);
                    $entity->setTypeSociete($data[3]);
                    $entity->setCommentaire($data[4]);
                    $entity->setStatusContrat($data[5]);
                    $entity->setTypeMission($data[6]);
                    $entity->setTarif($data[7]);
                    $entity->setHoraire($data[8]);
                    $entity->setTtcSst($data[9]);
                    $entity->setVolumeHoraire($data[10]);
                    $entity->setUnite($data[11]);
                    $entity->setDateDebut(new \DateTime($data[12]));
                    $entity->setDateFin(new \DateTime($data[13]));
                    $entity->setMatiere($matiere);
                    $entity->setPromotion($data[15]);
                    $entity->setAlternant($data[16]);
                    $entity->setPeriode($data[17]);
                    $entity->setRp($data[18]);
                    $entity->setTypeRecrutement($data[19]);
                    $entity->setDiplomeLePlusEleve($data[20]);
                    $entity->setDomaineCompetence1($data[21]);
                    $entity->setDomaineCompetence2($data[22]);
                    $entity->setDomaineCompetence3($data[23]);
                    $entity->setNiveauExpertisePedagogique($data[24]);
                    $entity->setNiveauExpertisePro($data[25]);
                    $entity->setEtat($data[26]);


                    $em->persist($entity);

                    if (($count % $batchSize) === 0) {
                        $em->flush();
                        $em->clear();
                    }
                }
                fclose($handle);
                $em->flush();
                $em->clear();
            }
        }

        return $this->render("admin/import.html.twig", [
            'form' => $form->createView()
        ]);
    }
public function configureFilters(Filters $filters): Filters
{
    return $filters
        ->add(ChoiceFilter::new('etat')->setChoices([
            'RH en cours de traitement' => 'RH en cours de traitement',
            'RH dossier complet mais à traiter' => 'RH dossier complet mais à traiter',
            'Contrat à faire - dossier complet' => 'Contrat à faire - dossier complet',
            'Attente documents' => 'Attente documents',
            'Ecart GP' => 'écart GP',
            'Annulé' => 'Annulé',
            'Fait' => 'Fait',
            'Envoyé' => 'Envoyé',
            'Signé' => 'Signé',
        ]))
        ->add('intervenant')
        ;
}


}
