<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/temoignages')]
class CommentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'testimonials', methods: ['GET'])]
    public function index(CommentRepository $commentRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $comments = $commentRepository->findBy(['status' => 'validated'], ['created_at' => 'DESC']);
        $paginationComments = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1),
            5
        );

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/testimonials/index.html.twig', [
            'comments' => $paginationComments,
            'current_route' => $current_route
        ]);
    }

    #[Route('/nouveau', name: 'testimonials_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, ValidatorInterface $validator, SessionInterface $session): Response
    {
        $comment = new Comment();
        $comment->setStatus('pending');
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentImage = $form->get('image')->getData();
            $commentDefaultImage = $this->getParameter('imagesDirectory') . '/default-user-silhouette.png';

            if ($commentImage) {
                $originalFilename = pathinfo($commentImage->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $commentImage->guessExtension();

                try {
                    $commentImage->move(
                        $this->getParameter('uploadDirectory') . '/comment_images',
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Une erreur est survenue lors de l\'enregistrement du fichier : ' . $e->getMessage());
                }

                $comment->setImage($newFilename);
            } else {
                $defaultImageFilename = 'default-user-silhouette-' . uniqid() . '.png';
                try {
                    copy(
                        $commentDefaultImage,
                        $this->getParameter('uploadDirectory') . '/comment_images/' . $defaultImageFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Une erreur est survenue lors de l\'enregistrement du fichier : ' . $e->getMessage());
                }

                $comment->setImage($defaultImageFilename);
            }

            $comment->setCreatedAt(new \DateTimeImmutable()); // Set the created_at field to the current date and time

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $session->getFlashBag()->add('success', 'Votre témoignage a bien été envoyé, il est en attente de validation.');

            return $this->redirectToRoute('testimonials');
        }

        if ($form->isSubmitted()) {
            $errors = $validator->validate($comment);
        } else {
            $errors = [];
        }

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/testimonials/new.html.twig', [
            'form' => $form->createView(),
            'comment' => $comment,
            'current_route' => $current_route
        ]);
    }
}
