<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ApiKeyListener
{
    private $container;
    private $requestStack;
    private $baseUrl;

    public function __construct(ContainerInterface $container, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();
        $this->baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath() . $request->getRequestUri();
    }


    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $apiKey = $request->headers->get('Mc-Validation-Verify');

        // Define la API Key permitida
        $allowedApiKey = $this->container->getParameter('MC_VALIDATION_VERIFY');

        if (str_contains($this->baseUrl, 'service')) {
            if ($apiKey !== $allowedApiKey) {
                $response = new Response('ACCESS_DENIED', Response::HTTP_NOT_FOUND);
                $event->setResponse($response);
            }
        }

    }
}
