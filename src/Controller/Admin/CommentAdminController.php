<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/temoignages')]
class CommentAdminController extends AbstractController
{
    #[Route('/validation/{id}', name: 'admin_comment_validate')]
    public function validateComment(Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $comment->setStatus('validated');
        $entityManager->flush();

        $this->addFlash('success', 'Le commentaire a été validé avec succès.');

        return $this->redirectToRoute('admin');
    }

    #[Route('/rejet/{id}', name: 'admin_comment_reject')]
    public function rejectComment(Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $comment->setStatus('rejected');
        $entityManager->flush();

        $this->addFlash('warning', 'Le commentaire a été rejeté.');

        return $this->redirectToRoute('admin');
    }
}
