<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClasseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')
                ->setLabel('Nom de la classe'),
            AssociationField::new('matiere')
                ->setRequired(true),
        ];
    }

}
