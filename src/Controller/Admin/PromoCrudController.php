<?php

namespace App\Controller\Admin;

use App\Entity\Promo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PromoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Promo::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')
                ->setLabel('Nom de la Promo'),
            CollectionField::new('classe')
                ->setRequired(true)
                ->onlyOnIndex(),
            AssociationField::new('classe')
                ->setRequired(true)
                ->onlyOnForms(),
        ];
    }

}
