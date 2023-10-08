<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/galerie')]
class PhotoController extends AbstractController
{
    #[Route('/photos', name: 'photos_gallery')]
    public function photoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
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

        return $this->render('pages/gallery/photos/all.html.twig', [
            'photos' => $photos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route
        ]);
    }

    #[Route('/photos/mariages', name: 'wedding_photos_gallery')]
    public function weddingPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
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

        return $this->render('pages/gallery/photos/weddings.html.twig', [
            'weddingPhotos' => $weddingPhotos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
            'current_category' => 'Mariages'
        ]);
    }

    #[Route('/photos/famille', name: 'family_photos_gallery')]
    public function familyPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos où la catégorie est 'Famille'
        $familyPhotos = array_filter($photos, function ($photo) {
            return $photo->getCategory()->getName() === 'Famille';
        });

        // Obtenir une photo aléatoire parmi les photos filtrées
        $randomPhoto = $familyPhotos[array_rand($familyPhotos)];

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photos/family.html.twig', [
            'familyPhotos' => $familyPhotos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
            'current_category' => 'Famille'
        ]);
    }

    #[Route('/photos/portraits', name: 'portraits_photos_gallery')]
    public function portraitsPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos où la catégorie est 'Portraits'
        $portraitsPhotos = array_filter($photos, function ($photo) {
            return $photo->getCategory()->getName() === 'Portraits';
        });

        // Obtenir une photo aléatoire parmi les photos filtrées
        $randomPhoto = $portraitsPhotos[array_rand($portraitsPhotos)];

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photos/portraits.html.twig', [
            'portraitsPhotos' => $portraitsPhotos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
            'current_category' => 'Portraits'
        ]);
    }

    #[Route('/photos/evenements', name: 'events_photos_gallery')]
    public function eventsPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos où la catégorie est 'Portraits'
        $eventsPhotos = array_filter($photos, function ($photo) {
            return $photo->getCategory()->getName() === 'Evènements';
        });

        // Obtenir une photo aléatoire parmi les photos filtrées
        $randomPhoto = $eventsPhotos[array_rand($eventsPhotos)];

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photos/events.html.twig', [
            'eventsPhotos' => $eventsPhotos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
            'current_category' => 'Evènements'
        ]);
    }

    #[Route('/photos/animaux', name: 'animals_photos_gallery')]
    public function animalsPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos où la catégorie est 'Portraits'
        $animalsPhotos = array_filter($photos, function ($photo) {
            return $photo->getCategory()->getName() === 'Animaux';
        });

        // Obtenir une photo aléatoire parmi les photos filtrées
        $randomPhoto = $animalsPhotos[array_rand($animalsPhotos)];

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photos/animals.html.twig', [
            'animalsPhotos' => $animalsPhotos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
            'current_category' => 'Animaux'
        ]);
    }

    #[Route('/photos/paysages', name: 'landscapes_photos_gallery')]
    public function landscapesPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos où la catégorie est 'Portraits'
        $landscapesPhotos = array_filter($photos, function ($photo) {
            return $photo->getCategory()->getName() === 'Paysages';
        });

        // Obtenir une photo aléatoire parmi les photos filtrées
        $randomPhoto = $landscapesPhotos[array_rand($landscapesPhotos)];

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photos/landscapes.html.twig', [
            'landscapesPhotos' => $landscapesPhotos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
            'current_category' => 'Paysages'
        ]);
    }
}
