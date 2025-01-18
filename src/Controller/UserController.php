<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ResetPasswordType;
use App\Form\ForgotPasswordType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Form\UserResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/utilisateur')]
class UserController extends AbstractController
{
    #[Route('/connexion', name: 'user_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $current_route = $request->attributes->get('_route');

        return $this->render('user/security/login.html.twig', [
            'error' => $error,
            'current_route' => $current_route
        ]);
    }

    #[Route('/nouvel-utilisateur', name: 'user_new', methods: ['GET', 'POST'])]
    public function newUser(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifiez si un utilisateur avec le même username/email existe déjà
            $existingUser = $userRepository->findOneBy(['email' => $user->getEmail()]);
            if ($existingUser) {
                // Ajouter un message flash pour indiquer l'erreur
                $this->addFlash('error', 'Un utilisateur avec cet email existe déjà. Veuillez en utiliser un autre.');

                return $this->redirectToRoute('user_new');
            }

            $user->setUsername($user->getEmail());

            // Hasher le mot de passe
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Attribuer le rôle d'admin
            $user->setRoles(['ROLE_ADMIN']);

            // Sauvegarder l'utilisateur
            $userRepository->save($user, true);

            // Ajouter un message flash pour la confirmation
            $this->addFlash('success', 'Votre compte a bien été créé.');

            // Ajouter un marqueur pour ignorer la sécurité lors de la redirection
            $request->getSession()->set('skip_security_check', true);

            // Rediriger vers la page de connexion
            return $this->redirectToRoute('user_login');
        }

        $current_route = $request->attributes->get('_route');

        return $this->renderForm('user/new.html.twig', [
            'current_route' => $current_route,
            'user' => $user,
            'form' => $form,
        ]);
    }    

    #[Route('/deconnexion', name:'user_logout')]
    public function logout()
    {
        // This method can be blank - it will be intercepted by the logout key on your firewall
    }
}
