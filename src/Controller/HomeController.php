<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotNull;

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
        $photosHomepage = $this->mediaRepository->findBy(['homepage' => true]);
        $current_route = $request->attributes->get('_route');

        return $this->render('home/index.html.twig', [
            'photosHomepage' => $photosHomepage,
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
