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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
    public function new(Request $request, ValidatorInterface $validator, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $comment = new Comment();

        // Utilisation du formulaire pour manipuler l'entité
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Ajoute l'image par défaut si aucune image n'a été téléchargée
            // if ($comment->getImageFile() === null) {
            //     $comment->setImage('public/images/comment/default-user-silhouette.png');
            // }

            // Définir le statut par défaut à "pending"
            $comment->setStatus('pending');

            // Enregistrement du commentaire
            $entityManager->persist($comment);
            $entityManager->flush();

            $session->getFlashBag()->add('success', 'Votre témoignage a bien été envoyé, il est en attente de validation.');

            return $this->redirectToRoute('testimonials');
        }

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/testimonials/new.html.twig', [
            'comment' => $comment,
            'current_route' => $current_route,
            'form' => $form->createView(),
        ]);
    }
}
