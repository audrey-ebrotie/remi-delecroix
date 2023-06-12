<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Entity\Video;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $pendingComments = $this->commentRepository->findPending();

        return $this->render('admin/dashboard.html.twig', [
            'pending_comments' => $pendingComments,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Remi Delecroix - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Photos', 'fa fa-image', Photo::class);
        yield MenuItem::linkToCrud('Videos', 'fa fa-film', Video::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Témoignages', 'fa fa-message', Comment::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);
    }
}
