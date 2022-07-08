<?php

namespace App\Controller\Admin;

use App\Entity\Matiere;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MatiereCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Matiere::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')
                ->setLabel('Nom de la matière'),
            ChoiceField::new('semestre')
                ->setChoices([
                    'Semestre 1' => 'Semestre 1',
                    'Semestre 2' => 'Semestre 2'
                ]),
            TextField::new('volume_heure')
                ->setLabel('Volume Horaire'),
        ];
//        TODO Réglé le problème de la relation avec classe
    }
}
