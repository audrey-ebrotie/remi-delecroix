<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom ou pseudo',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre prénom ou un pseudo.']),
                    new Length([
                        'min' => 2,
                        'max' => 45,
                        'minMessage' => 'Le prénom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom doit comporter au maximum {{ limit }} caractères.'
                    ])
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 45,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom doit comporter au maximum {{ limit }} caractères.',
                    ])
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre message',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un message.']),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Le message doit comporter au moins {{ limit }} caractères.'
                    ])
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Ajouter une image',
                'required' => false,
                'help' => 'fichiers acceptés : jpg, jpeg, png | taille max : 2 Mo',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Image([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
