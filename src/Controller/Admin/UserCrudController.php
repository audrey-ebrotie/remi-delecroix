<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('email');
        yield TextField::new('password');
        
        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
            yield FormField::addPanel('Définir un nouveau mot de passe')->setIcon('fa fa-lock')->addCssClass('bg-dark');
            yield TextField::new('plainPassword')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()
                ->setFormTypeOptions([
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Mot de passe',
                ]);
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Gestion des utilisateurs')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur');
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        return $user;
    }
}
