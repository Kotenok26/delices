<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Brand;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Header;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Region;
use App\Entity\Subcategory;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Cave aux Délices');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Commandes', 'fa fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Sous-categories', 'fa fa-tag', Subcategory::class);
        yield MenuItem::linkToCrud('Régions de France', 'fa fa-map-marker-alt', Region::class);
        yield MenuItem::linkToCrud('Fournisseurs', 'fa fa-star', Brand::class);
        yield MenuItem::linkToCrud('Produits', 'fa fa-gift', Product::class);
        yield MenuItem::linkToCrud('Transporteurs', 'fa fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Headers', 'fas fa-desktop', Header::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-edit', Article::class);

    }
}
