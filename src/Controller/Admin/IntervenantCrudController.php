<?php

namespace App\Controller\Admin;

use App\Entity\Intervenant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
            TextField::new('Email')
                ->setLabel('Adresse e-mail')
                ->setRequired(true)
                ->setColumns('col-6'),
            TextField::new('Telephone')
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
                    'Formateur' => 'blue',
                    'Admin' => 'red',
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

}
