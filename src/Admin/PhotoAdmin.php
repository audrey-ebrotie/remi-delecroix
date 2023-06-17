<?php 

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\ActionsType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

final class PhotoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('category', null, [
                'choice_value' => 'name',
                'label' => 'Catégorie',
                'required' => true,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('filename', VichFileType::class, [
                'label' => 'Fichier',
                'required' => false,
            ])
            ->add('homepage', CheckboxType::class, [
                'required' => false,
                'label' => 'Page d\'accueil',
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('category', null, [
                'label' => 'Catégorie',
            ]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('title', null, [
                'label' => 'Titre',
            ])
            ->add('category.name', null, [
                'label' => 'Catégorie',
            ])
            ->add('description', null, [
                'label' => 'Description',
            ])
            ->add('filename', null, [
                'label' => 'Aperçu',
                'template' => 'Admin/photo_preview.html.twig',
            ])
            ->add('created_at', null, [
                'label' => 'Créé le',
            ])
            ->add('homepage', 'boolean', [
                'editable' => true,
                'label' => 'Page d\'accueil',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
                'label' => 'Actions',
            ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('category.name', null, [
                'label' => 'Catégorie',
            ])
            ->add('description', null, [
                'label' => 'Description',
            ])
            ->add('filename', null, [
                'label' => 'Fichier',
            ])
            ->add('created_at', null, [
                'label' => 'Créé le',
            ])
            ->add('homepage', 'boolean', [
                'label' => 'Page d\'accueil',
            ]);
    }
}
