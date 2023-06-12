<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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
            $user->setUsername($user->getEmail());
            // Hash the password
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            // Set the role to admin
            $user->setRoles(['ROLE_ADMIN']);
    
            // Save the user
            $userRepository->save($user, true);
    
            return $this->redirectToRoute('user_login', [], Response::HTTP_SEE_OTHER);
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

    #[Route('/mot-de-passe-oublié', name: 'user_forgot_password')]
    public function forgotPassword(Request $request, UserRepository $userRepository, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            // Recherchez l'utilisateur par son adresse email
            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user) {
                // Générez un token de réinitialisation de mot de passe unique et l'associer à l'utilisateur
                $token = bin2hex(random_bytes(32));
                $user->setResetPasswordToken($token);

                // Enregistrez les modifications dans la base de données
                $entityManager->flush();

                // Envoyez un e-mail à l'utilisateur avec un lien pour réinitialiser son mot de passe
                $resetPasswordUrl = $this->generateUrl('user_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                // Utilisez le composant Mailer pour envoyer l'e-mail avec le lien de réinitialisation
                $email = (new Email())
                ->from('sender@example.com')
                ->to($user->getEmail())
                ->subject('Réinitialisation de votre mot de passe')
                ->html('<p>Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href="' . $resetPasswordUrl . '">Réinitialiser le mot de passe</a></p>');

                $mailer->send($email);

                // Affichez un message à l'utilisateur indiquant que l'e-mail de réinitialisation a été envoyé
                $this->addFlash('success', 'Un e-mail de réinitialisation de mot de passe a été envoyé.');

            } else {
                // Affichez un message d'erreur si l'adresse e-mail n'a pas été trouvée dans la base de données
                $this->addFlash('error', 'Aucun compte n\'existe avec l\'adresse e-mail renseignée. Je vous invite à <strong><u><a href="' . $this->generateUrl('user_new') . '">cliquer ici pour créer un compte</a></u></strong>.');
            }
        }

        $current_route = $request->attributes->get('_route');

        return $this->render('user/forgot_password.html.twig', [
            'current_route' => $current_route,
        ]);
    }

    #[Route('/reinitialisation-mot-de-passe/{token}', name: 'user_reset_password')]
    public function resetPassword(string $token, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        // ...

        // Vérifiez si l'utilisateur existe et que le token est valide
        if (!$user || !$user->isPasswordResetTokenValid()) {
            // Affichez un message d'erreur ou redirigez l'utilisateur vers une page appropriée
            // par exemple, une page indiquant que le lien de réinitialisation est invalide ou expiré
            // ...

            // Dans cet exemple, nous redirigeons simplement l'utilisateur vers la page de connexion
            return $this->redirectToRoute('user_login');
        }

        $form = $this->createForm(UserResetPasswordType::class, null, [
            'action' => $this->generateUrl('user_reset_password', ['token' => $token]),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez le nouveau mot de passe saisi par l'utilisateur
            $newPassword = $form->get('newPassword')->getData();

            // Hash le nouveau mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);

            // Mettez à jour le mot de passe de l'utilisateur avec le nouveau mot de passe hashé
            $user->setPassword($hashedPassword);
            $user->setResetPasswordToken(null); // Réinitialisez le token de réinitialisation

            // Enregistrez les modifications dans la base de données
            $entityManager->flush();

            // Affichez un message de succès ou redirigez l'utilisateur vers une page appropriée
            // par exemple, une page indiquant que le mot de passe a été réinitialisé avec succès
            // ...

            // Dans cet exemple, nous affichons simplement un message de confirmation
            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');

            // Redirigez l'utilisateur vers la page de connexion
            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
