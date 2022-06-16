<?php

namespace App\Controller\Admin;

use App\Entity\Intervenant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IntervenantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Intervenant::class;
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
                ->setChoices([
                    'Formateur' => 'Formateur',
                ])
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
            ->setPageTitle('index', '%entity_label_plural% list')

            // you can pass a PHP closure as the value of the title
            ->setPageTitle('new', 'Créez un Formateur')

            // in DETAIL and EDIT pages, the closure receives the current entity
            // as the first argument
            // the help message displayed to end users (it can contain HTML tags)
            ->setPageTitle('edit', 'Modifier un Formateur')
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
                return $action->setLabel('Ajouter un Formateur');
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
