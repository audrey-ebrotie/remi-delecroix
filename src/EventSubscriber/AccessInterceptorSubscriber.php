<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;

class AccessInterceptorSubscriber implements EventSubscriberInterface
{
    private $router;
    private $codeSecret;
    private $security;

    public function __construct(UrlGeneratorInterface $router, ParameterBagInterface $params, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
        $this->codeSecret = $params->get('app.security.code');
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => ['onKernelRequest', 0]];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();

        // Initialisation des questions et réponses
        $questionsEtReponses = [
            ['question' => 'Code secret ?', 'reponse' => $this->codeSecret],
        ];

        // Ne pas appliquer la logique si l'utilisateur est déjà authentifié
        if ($this->security->getUser()) {
            return;
        }

        // Ignorer la redirection si un paramètre de redirection temporaire est défini
        if ($request->getSession()->has('skip_security_check')) {
            $request->getSession()->remove('skip_security_check');
            return;
        }

        if (strpos($path, '/utilisateur/connexion') === 0) {
            $session = $request->getSession();

            // Vérifiez si une erreur d'authentification existe
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $error = $session->get($authErrorKey);

            if ($error) {
                // Ne redirige pas, laisse Symfony afficher l'erreur sur /utilisateur/connexion
                return;
            }

            $reponseUtilisateur = $request->query->get('reponse');
            $questionUtilisateur = $request->query->get('question');

            if ($reponseUtilisateur !== null) {
                $indexQuestion = array_rand($questionsEtReponses);
                $questionChoisie = $questionsEtReponses[$indexQuestion];

                if ($questionUtilisateur !== $questionChoisie['question'] ||
                    strtolower($reponseUtilisateur) !== strtolower($questionChoisie['reponse'])) {
                    $session->set('security_error', 'Le code saisi est incorrect.');
                    $session->set('questionChoisie', $questionChoisie);
                    $session->set('indexQuestion', $indexQuestion);

                    $url = $this->router->generate('security_question');
                    $event->setResponse(new RedirectResponse($url));
                }
            } else {
                $indexQuestion = array_rand($questionsEtReponses);
                $questionChoisie = $questionsEtReponses[$indexQuestion];
                $session->set('questionChoisie', $questionChoisie);
                $session->set('indexQuestion', $indexQuestion);

                $url = $this->router->generate('security_question');
                $event->setResponse(new RedirectResponse($url));
            }
        }
    }
}
