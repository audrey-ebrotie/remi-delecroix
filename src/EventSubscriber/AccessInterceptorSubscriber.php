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

    public function onKernelRequest(RequestEvent $event){
    $request = $event->getRequest();
    $path = $request->getPathInfo();

        if (strpos($path, '/utilisateur/connexion') === 0) {
            $session = $request->getSession();
            $reponseUtilisateur = $request->query->get('reponse');
            $questionUtilisateur = $request->query->get('question');

            // Ne définissez le message d'erreur que si une réponse a été soumise.
            if ($reponseUtilisateur !== null) {
                $indexQuestion = array_rand($this->questionsEtReponses);
                $questionChoisie = $this->questionsEtReponses[$indexQuestion];

                if ($questionUtilisateur !== $questionChoisie['question'] ||
                    strtolower($reponseUtilisateur) !== strtolower($questionChoisie['reponse'])) {
                    $session->set('security_error', 'N accepte que des caractères numériques au nombre de 6');
                    $session->set('questionChoisie', $questionChoisie);
                    $session->set('indexQuestion', $indexQuestion);

                    // Puis redirigez vers la page de la question de sécurité :
                    $url = $this->router->generate('security_question');
                    $event->setResponse(new RedirectResponse($url));
                } 
            } else {
                // Si aucune réponse n'a été soumise, affichez simplement la question sans erreur.
                $indexQuestion = array_rand($this->questionsEtReponses);
                $questionChoisie = $this->questionsEtReponses[$indexQuestion];
                $session->set('questionChoisie', $questionChoisie);
                $session->set('indexQuestion', $indexQuestion);

                $url = $this->router->generate('security_question');
                $event->setResponse(new RedirectResponse($url));
            }
        }
    }
}