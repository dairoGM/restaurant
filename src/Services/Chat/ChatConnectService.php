<?php

namespace App\Services\Chat;

use App\ExtendSys\Chat\ChatConnectInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\ExtendSys\Chat\ConnectConfig;
use App\ExtendSys\Chat\Model\ChatUser;
use App\Repository\Security\UsuarioChatRepository;
use Symfony\Component\Security\Core\Security;

/** 
 * Servicio del Chat 
 */
class ChatConnectService implements ChatConnectInterface
{

    private ContainerInterface $container;

    private Security $security;

    private UsuarioChatRepository $usuarioChatRepository;

    private $schemaChat;
    private $urlChat;
    private $tokenAdminChat;
    private $defaultTeamNameChat;

    public function __construct(ContainerInterface $container, Security $security, UsuarioChatRepository $usuarioChatRepository)
    {
        $this->container = $container;
        $this->security = $security;
        $this->usuarioChatRepository = $usuarioChatRepository;

        $this->schemaChat = $container->getParameter('schemaChat');
        $this->urlChat = $container->getParameter('urlChat');
        $this->tokenAdminChat = $container->getParameter('tokenAdminChat');   
        $this->defaultTeamNameChat = $container->getParameter('defaultTeamNameChat');      
    }   
    

    /**
     * Retorna la Config para conexión para Admnistrar
     *
     * @return ConnectConfig
     */
    function getAdminConnect() : ConnectConfig
    {
       $connectConfig = new ConnectConfig(
            $this->schemaChat,
            $this->urlChat,            
            $this->tokenAdminChat
       );

       return $connectConfig;
    }

    /**
     * Retorna la Config para conexión de un usuario logueado y asociado al chat
     *
     * @return ConnectConfig
     */
    function getUserConnect() : ConnectConfig
    {        

        $chatUser = $chatUser = $this->getLoginChatUser(); 

        $tokenChat = (isset($chatUser)) ? $chatUser->getToken() :  "";

        $connectConfig = new ConnectConfig(
            $this->schemaChat,
            $this->urlChat,            
            $tokenChat
       );

       return $connectConfig;
    }     

    /**
     * Devuelve el usuario actual logueado
     *
     * @return ChatUser
     */
    function getLoginChatUser() : ?ChatUser
    {
        $user = $this->security->getUser();      
                  
        $usuarioChat = $this->usuarioChatRepository->getUsuarioChatByUsuario($user);

      
        if(null != $usuarioChat)
        {        
            $chatUser = new ChatUser();
            $chatUser->setId($usuarioChat->getChatId());
            $chatUser->setToken($usuarioChat->getToken());
            $chatUser->setUsername($usuarioChat->getUserchat());
            $chatUser->setEmail($usuarioChat->getEmail());
            $chatUser->setPassword($usuarioChat->getPassword());
            $chatUser->setFirstName($usuarioChat->getNombre());
            $chatUser->setLastName($usuarioChat->getApellido());
            $chatUser->setNickname($usuarioChat->getNickname());
            $chatUser->setTeamId($usuarioChat->getTeamdId());      
            $chatUser->setAlgPassEncrypt($usuarioChat->getAlgPassEncrypt());
            $chatUser->setMatchId($usuarioChat->getPersona()->getId());
                
            return $chatUser;
        }

        return null;
    }

    /**
     *  Retorna el Team name configurado por defecto
     *
     * @return string
     */
    function getDefaultTeamName() : string
    {
        return $this->defaultTeamNameChat;
    }
}
