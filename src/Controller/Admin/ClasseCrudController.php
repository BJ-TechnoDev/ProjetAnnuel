<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use App\Entity\Matiere;
use App\Service\CsvService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClasseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classe::class;
    }

    private CsvService $csvService;

    public function __construct(CsvService $csvService, EntityManagerInterface $em)
    {
        $this->csvService = $csvService;
        $this->entityManager = $em;

    }

    public function configureFields(string $pageName): iterable
    {
        $Matiererepo = $this->entityManager->getRepository(Matiere::class);
        return [
            TextField::new('nom')
                ->setLabel('Nom de la classe'),
            CollectionField::new('matiere')
                ->setRequired(true)
                ->onlyOnIndex()
                ->setLabel('Nom de la classe')
                ->setColumns('col-4'),
            AssociationField::new('matiere')
                ->setRequired(true)
                ->onlyOnForms()
                ->setLabel('Matière')
                ->setColumns('col-4'),
        ];
    }

}
