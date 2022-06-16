<?php

namespace App\Controller\Admin;

use App\Entity\Contrat;
use App\Entity\Intervenant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContratCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contrat::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new("intervenant")
                ->setLabel('Formateur')
                ->setRequired(true)
                ->setColumns('col-4'),
            DateField::new('dateDemande')
                ->setLabel('Date Demande')
                ->setRequired(true)
                ->setColumns('col-4'),
            TextField::new('marqueOuEcole')
                ->setLabel('Marque / Ecole')
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
                ->autocomplete()
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
                ->setLabel('Etat')
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
            // the visible title at the top of the page and the content of the <title> element
            // it can include these placeholders:
            //   %entity_name%, %entity_as_string%,
            //   %entity_id%, %entity_short_id%
            //   %entity_label_singular%, %entity_label_plural%
            ->setPageTitle('index', '%entity_label_plural% liste')

            // you can pass a PHP closure as the value of the title
            ->setPageTitle('new', 'Créez un Contrat')

            // in DETAIL and EDIT pages, the closure receives the current entity
            // as the first argument
            // the help message displayed to end users (it can contain HTML tags)
            ->setPageTitle('edit', 'Modifier un Contrat')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
//            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Sauvegarder et continuer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Créer');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter un Contrat');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Sauvegarder les changements');
            })
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
            // in PHP 7.4 and newer you can use arrow functions
            // ->update(Crud::PAGE_INDEX, Action::NEW,
            //     fn (Action $action) => $action->setIcon('fa fa-file-alt')->setLabel(false))
            ;
    }

}
