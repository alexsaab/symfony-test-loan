<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Credit;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Panel')
            ->setFaviconPath('favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Users');
            yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        }

        if ($this->isGranted('ROLE_MANAGER') || $this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Clients');
            yield MenuItem::linkToCrud('Clients', 'fas fa-address-card', Client::class);

            yield MenuItem::section('Finance');
            yield MenuItem::linkToCrud('Credits', 'fas fa-credit-card', Credit::class);
        } else {
            yield MenuItem::section('Clients');
            yield MenuItem::linkToCrud('Clients', 'fas fa-address-card', Client::class);

            yield MenuItem::section('Finance');
            yield MenuItem::linkToCrud('Credits', 'fas fa-credit-card', Credit::class);
        }

        yield MenuItem::section('Account');
        yield MenuItem::linkToRoute('My Profile', 'fas fa-user', 'fos_user_profile_show');
        yield MenuItem::linkToRoute('Logout', 'fas fa-sign-out-alt', 'fos_user_security_logout');
    }
}
