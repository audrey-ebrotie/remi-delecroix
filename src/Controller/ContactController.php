<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Psr\Log\LoggerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_me')]
    public function index(Request $request, MailerInterface $mailer, LoggerInterface $logger): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez les données du formulaire ici, par exemple en les envoyant par e-mail ou en les enregistrant dans la base de données
            $contactFormData = $form->getData();

            // Créer un e-mail
            $email = (new Email())
                ->from($contactFormData['email'])
                ->to('audrey.ebrotie@gmail.com') // Remplacez par l'adresse e-mail où vous souhaitez recevoir les messages
                ->subject('Nouveau message de contact: ' . $contactFormData['objet'])
                ->text(
                    "Nom: " . $contactFormData['nom'] . "\n" .
                        "Prénom: " . $contactFormData['prenom'] . "\n" .
                        "E-mail: " . $contactFormData['email'] . "\n" .
                        "Téléphone: " . $contactFormData['telephone'] . "\n" .
                        "Message: \n" . $contactFormData['message']
                );

            // Envoyer l'e-mail
            $logger->info('Sending email', ['email' => $email]);
            $mailer->send($email);
            $logger->info('Email sent');

            $this->addFlash('success', 'Votre message a été envoyé avec succès !');

            return $this->redirectToRoute('contact_me');
        }

        $current_route = $request->attributes->get('_route');

        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView(),
            'current_route' => $current_route
        ]);
    }
}
