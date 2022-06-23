<?php

namespace App\Controller\Admin;


use App\Entity\Contrat;
use App\Entity\Intervenant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Onyle')
            ->setFaviconPath('build/favicon 2.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('Accès au site');
        yield MenuItem::linkToRoute("Accéder à votre site", 'fa fa-arrow-right-to-bracket', 'homepage');
        yield MenuItem::section('Intervenants');
        yield MenuItem::linkToCrud("Intervenant", "fa fa-users", Intervenant::class);
        yield MenuItem::section('Demande de Contrat');
        yield MenuItem::linkToCrud("Accéder à vos contrat", "fa fa-file-contract", Contrat::class);
        yield MenuItem::section('Import / Export');
        yield MenuItem::linkToRoute("Import Contrat", "fa fa-file-arrow-down", '#');
        yield MenuItem::LinkToCrud("Import Maquette", 'fa fa-laptop-file', Intervenant::class);
        yield MenuItem::linkToRoute("Export en GoogleSheet", 'fa fa-file-arrow-up', '#');

    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('easyadmin');
    }

}
