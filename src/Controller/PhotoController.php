<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PhotoRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/galerie')]
class PhotoController extends AbstractController
{
    // Méthode générique pour les galeries de catégorie
    private function categoryPhotoGallery(string $categoryName, string $templateName, PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $photosQuery = $photoRepository->findByCategory($categoryName);
        $categories = $categoryRepository->findAll();

        $pagination = $paginator->paginate(
            $photosQuery,
            $request->query->getInt('page', 1),
            16 // ajustez selon les besoins
        );

        $randomPhoto = $pagination->getItems()[array_rand($pagination->getItems())];
        $current_route = $request->attributes->get('_route');

        return $this->render($templateName, [
            'photos' => $pagination,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route,
            'current_category' => $categoryName
        ]);
    }

    // Galerie générale
    #[Route('/toutes-les-photos', name: 'photos_gallery')]
    public function photoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Récupérez toutes les photos et triez-les par date de création (par exemple)
        $photosQuery = $photoRepository->findBy([], ['created_at' => 'DESC']);
    
        $categories = $categoryRepository->findAll();
    
        $pagination = $paginator->paginate(
            $photosQuery,
            $request->query->getInt('page', 1),
            16 // Nombre de photos par page, ajustez selon les besoins
        );
    
        // Sélectionnez une photo aléatoire
        $randomPhoto = $pagination->getItems()[array_rand($pagination->getItems())];
    
        $current_route = $request->attributes->get('_route');
    
        return $this->render('pages/gallery/photos/all.html.twig', [
            'photos' => $pagination,
            'categories' => $categories,
            'randomPhoto' => $randomPhoto,
            'current_route' => $current_route
        ]);
    }
    
    // Photos de mariage
    #[Route('/photos/mariages', name: 'wedding_photos_gallery')]
    public function weddingPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        return $this->categoryPhotoGallery('Mariages', 'pages/gallery/photos/weddings.html.twig', $photoRepository, $categoryRepository, $request, $paginator);
    }

    // Photos de famille
    #[Route('/photos/famille', name: 'family_photos_gallery')]
    public function familyPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        return $this->categoryPhotoGallery('Famille', 'pages/gallery/photos/family.html.twig', $photoRepository, $categoryRepository, $request, $paginator);
    }

    // Photos de portraits
    #[Route('/photos/portraits', name: 'portraits_photos_gallery')]
    public function portraitsPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        return $this->categoryPhotoGallery('Portraits', 'pages/gallery/photos/portraits.html.twig', $photoRepository, $categoryRepository, $request, $paginator);
    }

    // Photos d'événements
    #[Route('/photos/evenements', name: 'events_photos_gallery')]
    public function eventsPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        return $this->categoryPhotoGallery('Evènements', 'pages/gallery/photos/events.html.twig', $photoRepository, $categoryRepository, $request, $paginator);
    }

    // Photos d'animaux
    #[Route('/photos/animaux', name: 'animals_photos_gallery')]
    public function animalsPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        return $this->categoryPhotoGallery('Animaux', 'pages/gallery/photos/animals.html.twig', $photoRepository, $categoryRepository, $request, $paginator);
    }

    // Photos de paysages
    #[Route('/photos/paysages', name: 'landscapes_photos_gallery')]
    public function landscapesPhotoGallery(PhotoRepository $photoRepository, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        return $this->categoryPhotoGallery('Paysages', 'pages/gallery/photos/landscapes.html.twig', $photoRepository, $categoryRepository, $request, $paginator);
    }
}
