<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('firstname')
            ->setLabel('Prénom');
        yield TextField::new('lastname')
            ->setLabel('Nom');
        yield TextField::new('content')
            ->setLabel('Texte');
        yield ImageField::new('image')->setBasePath('/uploads/comment_images')->onlyOnIndex();
        yield DateTimeField::new('created_at')
        ->setLabel('Créé le')
        ->onlyOnIndex();
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable('new'); // Désactive le bouton "Créer Comment"
    }
}
