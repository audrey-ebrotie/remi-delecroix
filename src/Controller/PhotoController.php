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
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos où la catégorie est 'Mariages'
        $weddingPhotos = array_filter($photos, function ($photo) {
            return $photo->getCategory()->getName() === 'Mariages';
        });

        // Obtenir une photo aléatoire parmi les photos filtrées
        $randomPhoto = $weddingPhotos[array_rand($weddingPhotos)];

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photo.html.twig', [
            'photos' => $photos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route
        ]);
    }
}
