<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PhotoController extends AbstractController
{
    #[Route('/galerie/photos', name: 'photo_gallery')]
    public function gallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $photos = $photoRepository->findBy([], ['created_at' => 'DESC']);
        $categories = $categoryRepository->findAll();

        $latestPhoto = $photoRepository->findBy(
            [], ['created_at' => 'DESC'], 1 
        )[0] ?? null;

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photo.html.twig', [
            'photos' => $photos,
            'categories' => $categories,
            'latestPhoto' => $latestPhoto,
            'current_route' => $current_route
        ]);
    }
}
