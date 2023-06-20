<?php

namespace App\Admin;

use Sonata\Form\Type\BooleanType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\ActionsType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class CommentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('content', TextType::class, [
                'label' => 'Contenu',
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'download_label' => 'Télécharger',
                'label' => 'Fichier',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'pending',
                    'Validé' => 'validated',
                    'Rejeté' => 'rejected',
                ],
                'label' => 'Statut',
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('firstname', null, [
                'label' => 'Prénom',
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('status', null, [
                'label' => 'Statut',
            ]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('firstname', null, [
                'label' => 'Prénom',
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('content', null, [
                'label' => 'Contenu',
            ])
            ->add('image', null, [
                'label' => 'Image',
                'template' => 'Admin/comment_image_preview.html.twig',
            ])
            ->add('created_at', null, [
                'label' => 'Créé le',
            ])
            ->add('status', null, [
                'label' => 'Statut',
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
            ->add('firstname', null, [
                'label' => 'Prénom',
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('content', null, [
                'label' => 'Contenu',
            ])
            ->add('image', null, [
                'label' => 'Image',
            ])
            ->add('created_at', null, [
                'label' => 'Créé le',
            ])
            ->add('status', null, [
                'label' => 'Statut',
            ]);
    }
}
