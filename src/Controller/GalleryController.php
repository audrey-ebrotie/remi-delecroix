<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    #[Route('/galerie', name: 'gallery')]
    public function gallery(PhotoRepository $photoRepository, Request $request): Response
    {
        $current_route = $request->attributes->get('_route');

        return $this->render('pages/gallery/index.html.twig', [
            'current_route' => $current_route
        ]);
    }
}
