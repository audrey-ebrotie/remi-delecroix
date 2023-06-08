<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Repository\CategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Video::class;
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
        yield Field::new('videoFile', 'Video')
            ->setFormType(FileType::class)
            ->setFormTypeOptions([
                'label' => 'Video',
                'required' => false,
            ])
            ->onlyOnForms();
        yield ImageField::new('filename')
            ->setBasePath('/uploads/gallery_videos')
            ->setLabel('filename')
            ->onlyOnIndex();
        yield DateTimeField::new('created_at')->onlyOnIndex();
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Videos')
            ->setEntityLabelInSingular('Video')
            ->setPageTitle('index', 'Gestion des vidéos');
    }
}
