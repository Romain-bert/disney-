<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Videos;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {

    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class, VideosCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Disney- ADMIN');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW);
        yield MenuItem::linkToCrud('Visualiser', 'fas fa-eye', User::class);

        yield MenuItem::section('Vidéos');
        yield MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Videos::class)->setAction(Crud::PAGE_NEW);
        yield MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Videos::class);

        yield MenuItem::section('Commentaires');
        yield MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Comment::class)->setAction(Crud::PAGE_NEW);
        yield MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Comment::class);

    }
}
