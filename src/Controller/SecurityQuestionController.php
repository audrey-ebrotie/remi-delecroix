<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityQuestionController extends AbstractController
{
    /**
     * @Route("/security-question", name="security_question")
     */
    public function index(Request $request, SessionInterface $session)
    {
        // Supposons que vous stockez la question choisie aléatoirement et son index dans la session
        $questionChoisie = $session->get('questionChoisie');
        $indexQuestion = $session->get('indexQuestion');

        if (!$questionChoisie) {
            // Redirigez l'utilisateur ou gérez l'absence de question
            return $this->redirectToRoute('home'); 
        }

        return $this->render('security_question/index.html.twig', [
            'question' => $questionChoisie['question'],
            'current_route' => 'security_question',
        ]);
    }
}