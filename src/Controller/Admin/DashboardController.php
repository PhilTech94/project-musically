<?php

namespace App\Controller\Admin;

use App\Entity\Billing;
use App\Entity\Category;
use App\Entity\Sound;
use App\Entity\Style;
use App\Entity\User;
use App\Repository\BillingRepository;
use App\Repository\CategoryRepository;
use App\Repository\SoundRepository;
use App\Repository\StyleRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private SoundRepository $soundRepository,
        private CategoryRepository $categoryRepository,
        private StyleRepository $styleRepository,
        private BillingRepository $billingRepository
    ) {}

    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'soundCount' => $this->soundRepository->count([]),
            'categoryCount' => $this->categoryRepository->count([]),
            'styleCount' => $this->styleRepository->count([]),
            'billingCount' => $this->billingRepository->count([]),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Musically Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::linkToRoute('Sons', 'fa fa-music', 'admin_sound_index');
        yield MenuItem::linkToRoute('Catégories', 'fa fa-folder', 'admin_category_index');
        yield MenuItem::linkToRoute('Styles', 'fa fa-tags', 'admin_style_index');
        yield MenuItem::linkToRoute('Facturation', 'fa fa-file-invoice', 'admin_billing_index');
        yield MenuItem::linkToRoute('Utilisateurs', 'fa fa-users', 'admin_user_index');
    }
}
