<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $mediaRepository;

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $medias = $this->mediaRepository->findBy(['type' => 'photo'], ['created_at' => 'DESC'], 5);
        $current_route = $request->attributes->get('_route');

        return $this->render('home/index.html.twig', [
            'medias' => $medias,
            'current_route' => $current_route
        ]);
    }

    #[Route('/a-propos', name: 'about_me')]
    public function about(Request $request): Response
    {
        $current_route = $request->attributes->get('_route');

        return $this->render('pages/about-me.html.twig', [
            'current_route' => $current_route
        ]);
    }
}
