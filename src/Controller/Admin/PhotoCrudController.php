<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Repository\CategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('category')
            ->setFormTypeOption('choice_label', 'name')
            ->setFormTypeOption('query_builder', fn(CategoryRepository $repo) => $repo->createQueryBuilder('c')->orderBy('c.name', 'ASC'));
        yield TextField::new('category_name')
            ->setLabel('Category')
            ->onlyOnIndex();   
        yield TextField::new('title');
        yield TextField::new('description');
        yield ImageField::new('filename')
            ->setBasePath('/uploads/gallery_photos')
            ->setUploadDir('public/uploads/gallery_photos');
        yield BooleanField::new('homepage')->setLabel('Homepage');
        yield DateTimeField::new('created_at')->onlyOnIndex();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Photos')
            ->setEntityLabelInSingular('Photo')
            ->setPageTitle('index', 'Gestion des photos');
    }
}
