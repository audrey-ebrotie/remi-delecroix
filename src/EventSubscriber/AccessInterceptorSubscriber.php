<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AccessInterceptorSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Priorité 0 par défaut. Augmentez la valeur pour une exécution précoce.
        return [KernelEvents::REQUEST => ['onKernelRequest', 0]];
    }

    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    private $questionsEtReponses = [
        ['question' => 'Code secret ?', 'reponse' => '883382'],
    ];

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();

        if (strpos($path, '/utilisateur/connexion') === 0) {
            // Sélectionnez une question aléatoire
            $indexQuestion = array_rand($this->questionsEtReponses);
            $questionChoisie = $this->questionsEtReponses[$indexQuestion];

            // Supposons que la question est passée comme un paramètre GET pour simplifier
            $reponseUtilisateur = $request->query->get('reponse');
            $questionUtilisateur = $request->query->get('question');

            if ($questionUtilisateur !== $questionChoisie['question'] ||
            strtolower($reponseUtilisateur) !== strtolower($questionChoisie['reponse'])) {
                $session = $request->getSession();
                $indexQuestion = array_rand($this->questionsEtReponses);
                $questionChoisie = $this->questionsEtReponses[$indexQuestion];
                $session->set('questionChoisie', $questionChoisie);
                $session->set('indexQuestion', $indexQuestion);
                
                // Puis redirigez vers la page de la question de sécurité :
                $url = $this->router->generate('security_question');
                $event->setResponse(new RedirectResponse($url));
            }
        }
    }
}