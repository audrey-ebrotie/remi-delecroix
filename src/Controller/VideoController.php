<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    #[Route('/galerie/videos', name: 'video_gallery')]
    public function galleryVideos(VideoRepository $videoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $videos = $videoRepository->findBy([]);
        shuffle($videos); 
        $categories = $categoryRepository->findAll();

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/video.html.twig', [
            'videos' => $videos,
            'categories' => $categories,
            'current_route' => $current_route
        ]);
    }
}
