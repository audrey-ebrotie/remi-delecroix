<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AccessInterceptorSubscriber implements EventSubscriberInterface
{
    private $router;
    private $codeSecret;

    public function __construct(UrlGeneratorInterface $router, ParameterBagInterface $params)
    {
        $this->router = $router;
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

        // Initialisation des questions et des réponses ici, après que $this->codeSecret soit défini
        $questionsEtReponses = [
            ['question' => 'Code secret ?', 'reponse' => $this->codeSecret],
        ];

        if (strpos($path, '/utilisateur/connexion') === 0) {
            $session = $request->getSession();
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
