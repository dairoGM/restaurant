<?php

namespace App\Controller;

use App\Services\Chat\MyChatService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Log\LoggerInterface;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
   
    /**
     * @Route("/gotochat", name="app_chat_redirect", methods={"GET"})
     * @param ContainerInterface $container
     * @return Response
     */
    public function gotoChar(ContainerInterface $container)
    {            
        $url = $container->getParameter('fullLoginUrlChat');
        return new RedirectResponse($url);
    }

    /**
     * @Route("/mensages/noleidos", name="app_chat_mensagesnl", methods={"POST"})
     * @param MyChatService $myChatService
     */
    public function mensagesNoLeidos(MyChatService $myChatService, LoggerInterface $logger)
    {       
        try {
            $mnl = $myChatService->getUnreadMessages();
            
            return $this->json(['cant' => $mnl]);
        } 
        catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        } 
        
        return $this->json(['cant' => 0]); 
    }

    /**
     * @Route("/mensages/last", name="app_chat_lastmsg", methods={"POST"})
     * @param MyChatService $myChatService
     */
    public function lastMensages(MyChatService $myChatService, LoggerInterface $logger)
    {       
        try {
            $msgs = $myChatService->getLastMessages(8);
            
            return $this->json(['mensajes' => $msgs]);
        } 
        catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        } 
        
        return $this->json(['mensajes' => array()]); 
    }
}
