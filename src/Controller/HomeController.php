<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        $medias = $this->mediaRepository->findBy(['type' => 'photo'], ['created_at' => 'DESC'], 5);

        return $this->render('home/index.html.twig', [
            'medias' => $medias,
        ]);
    }

    #[Route('/galerie', name: 'gallery')]
    public function gallery(): Response
    {
        return $this->render('pages/gallery.html.twig', []);
    }

    #[Route('/a-propos', name: 'about_me')]
    public function about(): Response
    {
        return $this->render('pages/about-me.html.twig', []);
    }
}
