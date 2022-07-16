<?php

namespace App\Controller\Admin;

use App\Entity\Ecole;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EcoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ecole::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')
                ->setLabel('Nom de l\'école'),
            AssociationField::new('promo')
                ->setRequired(true),
        ];
    }

}
