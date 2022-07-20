<?php

namespace App\Controller\Admin;


use App\Entity\Classe;
use App\Entity\Contrat;
use App\Entity\Ecole;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Entity\Promo;
use App\Entity\User;
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
            ->setTitle('<img src="favicon-32x32.png" alt=""> <span style="color: #023165">ONY</span><span style="color: #29C7E5">LE</span>')
            ->setFaviconPath('build/favicon 2.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('Accès au site')->setCssClass('text-black');
        yield MenuItem::linkToRoute("Accéder à votre site", 'fa fa-arrow-right-to-bracket', 'homepage');
        yield MenuItem::section('Users')->setCssClass('text-black');
        yield MenuItem::linktoCrud('Utilisateur', 'fa fa-folder-open', User::class);
        yield MenuItem::section('Intervenants')->setCssClass('text-black');
        yield MenuItem::linkToCrud("Intervenant", "fa fa-folder-open", Intervenant::class);
        yield MenuItem::section('Demande de Contrat')->setCssClass('text-black');
        yield MenuItem::linkToCrud("Accéder à vos contrat", "fa fa-folder-open", Contrat::class);
        yield MenuItem::section('Maquette Pédagogique')->setCssClass('text-black');
        yield MenuItem::linkToCrud('École', 'fa fa-folder-open', Ecole::class);
        yield MenuItem::linkToCrud('Promo', 'fa fa-folder-open', Promo::class);
        yield MenuItem::linkToCrud('Classe', 'fa fa-folder-open', Classe::class);
        yield MenuItem::linkToCrud('Matière', 'fa fa-folder-open', Matiere::class);
        yield MenuItem::section('Export GoogleSheet')->setCssClass('text-black');
        yield MenuItem::linkToRoute("Export en GoogleSheet", 'fa fa-file-arrow-up', '#');
        yield MenuItem::section('Se Déconnecter')->setCssClass('text-black');
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-right-to-bracket');
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('easyadmin');
    }

}
