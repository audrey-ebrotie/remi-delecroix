<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediaController extends AbstractController
{
    #[Route('/galerie', name: 'gallery')]
    public function gallery(MediaRepository $mediaRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $medias = $mediaRepository->findAll();
        $categories = $categoryRepository->findAll();

        $latestPhoto = $mediaRepository->findOneBy(
            ['type' => 'photo'],
            ['created_at' => 'DESC']
        );

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery.html.twig', [
            'medias' => $medias,
            'categories' => $categories,
            'latestPhoto' => $latestPhoto,
            'current_route' => $current_route
        ]);
    }
}
