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
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class CommentAdmin extends AbstractAdmin
{
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
                'template' => 'Admin/comment/comment_image_preview.html.twig',
            ])
            ->add('created_at', null, [
                'label' => 'Créé le',
            ])
            ->add('status', null, [
                'label' => 'Statut',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'delete' => [],
                    'validate' => [
                        'template' => 'Admin/comment/validate_action.html.twig'
                    ],
                    'reject' => [
                        'template' => 'Admin/comment/reject_action.html.twig'
                    ],
                ],
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

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('validate', $this->getRouterIdParameter().'/validate')
            ->add('reject', $this->getRouterIdParameter().'/reject');
    }

}
