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
    // Tableau associatif pour mapper les noms de catégories en anglais et en français
    private $categoryMap = [
        'wedding' => 'Mariages',
        'family' => 'Famille',
        'portraits' => 'Portraits',
        'events' => 'Evènements',
        'animals' => 'Animaux',
        'landscapes' => 'Paysages',
    ];

    // Méthode pour afficher toutes les photos avec une photo en-tête de la catégorie 'Mariages'
    #[Route('/photos', name: 'photos_gallery')]
    public function photoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        // Récupérer toutes les photos et les catégories
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos où la catégorie est 'Mariages'
        $weddingPhotos = array_filter($photos, function ($photo) {
            return $photo->getCategory()->getName() === 'Mariages';
        });

        // Obtenir une photo en-tête aléatoire parmi les photos filtrées
        $randomPhoto = $weddingPhotos[array_rand($weddingPhotos)];

        // Obtenir le nom de la route courante
        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/photos/all.html.twig', [
            'photos' => $photos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
        ]);
    }

    // Méthode pour afficher les photos par catégorie
    #[Route('/photos/{categoryName}', name: 'category_photos_gallery')]
    public function categoryPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, string $categoryName): Response
    {
        // Vérifier si la catégorie existe
        if (!isset($this->categoryMap[$categoryName])) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }

        // Obtenir le nom de la catégorie en français
        $frenchCategoryName = $this->categoryMap[$categoryName];

        // Récupérer toutes les photos et les catégories
        $photos = $photoRepository->findBy([]);
        shuffle($photos);
        $categories = $categoryRepository->findAll();

        // Filtrer les photos basées sur la catégorie en français
        $filteredPhotos = array_filter($photos, function ($photo) use ($frenchCategoryName) {
            return $photo->getCategory()->getName() === $frenchCategoryName;
        });

        // Vérifier si des photos existent pour cette catégorie
        if (empty($filteredPhotos)) {
            throw $this->createNotFoundException('Aucune photo dans cette catégorie');
        }

        // Obtenir une photo en-tête aléatoire parmi les photos filtrées
        $randomPhoto = $filteredPhotos[array_rand($filteredPhotos)];

        // Obtenir le nom de la route courante
        $current_route = $request->attributes->get('_route');

        return $this->render("pages/gallery/photos/{$categoryName}.html.twig", [
            'photos' => $filteredPhotos,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
        ]);
    }
}
