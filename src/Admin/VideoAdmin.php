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

final class VideoAdmin extends AbstractAdmin
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
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('videoFile', VichFileType::class, [
                'label' => 'Fichier',
                'required' => false,
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
            ->add('videoFile', null, [
                'label' => 'Vidéo',
                'template' => 'Admin/video_preview.html.twig',
            ])
            ->add('created_at', null, [
                'label' => 'Créé le',
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
            ->add('videoFile', null, [
                'label' => 'Fichier',
                'template' => 'Admin/video_preview.html.twig',
            ])
            ->add('created_at', null, [
                'label' => 'Créé le',
            ]);
    }

    public function prePersist(object $object): void
    {
        $this->uploadFile($object);
    }

    public function preUpdate(object $object): void
    {
        $this->uploadFile($object);
    }

    private function uploadFile($object): void
    {
        /** @var Video $object */
        $file = $object->getFilename();
        if ($file instanceof UploadedFile) {
            $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $object->setFilename($fileName);

            // Set the uploaded file as a new File instance
            $object->setFile(new File($this->getParameter('upload_directory') . '/' . $fileName));
        }
    }

}
