<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediaController extends AbstractController
{
    #[Route('/galerie', name: 'gallery')]
    public function index(MediaRepository $mediaRepository, CategoryRepository $categoryRepository): Response
    {
        $medias = $mediaRepository->findAll();
        $categories = $categoryRepository->findAll();

        $latestPhoto = $mediaRepository->findOneBy(
            ['type' => 'photo'],
            ['created_at' => 'DESC']
        );

        return $this->render('pages/gallery.html.twig', [
            'medias' => $medias,
            'categories' => $categories,
            'latestPhoto' => $latestPhoto
        ]);
    }
}
