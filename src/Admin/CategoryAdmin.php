<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\ActionsType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
        ->add('name', TextType::class, [
            'label' => 'Nom',
        ])
        ->add('description', TextType::class, [
            'label' => 'Description',
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('name', null, [
            'label' => 'Nom'
        ])
        ->add('description', null, [
            'label' => 'Description',
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
        ->add('name', TextType::class, [
            'label' => 'Nom',
        ])
        ->add('description', TextType::class, [
            'label' => 'Description',
        ]);
    }
}