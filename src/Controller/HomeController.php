<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    #[Route('/', name: 'home')]
    public function home(Request $request): Response
    {
        $photosHomepage = $this->photoRepository->findBy(['homepage' => true]);
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
