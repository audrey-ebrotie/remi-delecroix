<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('firstname');
        yield TextField::new('lastname');
        yield TextField::new('content');
        yield ImageField::new('image')->setBasePath('/uploads/comment_images')->onlyOnIndex();
        yield DateTimeField::new('created_at')->onlyOnIndex();
        yield ChoiceField::new('status')->setChoices([
            'En attente' => 'pending',
            'Validé' => 'validated',
            'Rejeté' => 'rejected',
        ]);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Gestion des témoignages');
    }

    public function validateComment(Comment $comment): Response
    {
        $comment->setStatus('validated');
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Le commentaire a été validé avec succès.');

        return $this->redirectToRoute('admin');
    }

    public function rejectComment(Comment $comment): Response
    {
        $comment->setStatus('rejected');
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('warning', 'Le commentaire a été rejeté.');

        return $this->redirectToRoute('admin');
    }
}
