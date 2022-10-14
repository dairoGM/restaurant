<?php

namespace App\Services\Chat;

use App\Entity\Personal\Persona;
use App\Entity\Security\User;
use App\Entity\Security\UsuarioChat;
use App\ExtendSys\Chat\Model\ChatUser;
use App\ExtendSys\Chat\Model\ConInfo;
use App\Repository\Personal\PersonaRepository;
use App\Repository\Security\UsuarioChatRepository;
use Psr\Log\LoggerInterface;
use DateTime;
use Exception;

/** 
 * Servicio del Chat : MYCHATSERVICE
 */
class MyChatService
{
    //Algoritm for save password
    private $currentAlg;

    private GatewayChatService $gatewayChatService;

    private UsuarioChatRepository $usuarioChatRepository;

    private PersonaRepository $personaRepository;

    private LoggerInterface $logger;


    public function __construct(GatewayChatService $gatewayChatService, UsuarioChatRepository $usuarioChatRepository, PersonaRepository $personaRepository, LoggerInterface $logger)
    {       
        $this->currentAlg = AlgPassEncrypt::$ALG_SMPLTXT;

        $this->gatewayChatService = $gatewayChatService;
        $this->usuarioChatRepository = $usuarioChatRepository;
        $this->personaRepository = $personaRepository;
        $this->logger = $logger;
    }

    public function test()
    {        
       pr($this->getLastMessages(10));
       pr($this->testConnection());
    }   

    public function testConnection() : ConInfo
    {
        return $this->gatewayChatService->testConnection();
    }

    /**
     * Devuelve usuario del chat dado persona
     *
     * @param Persona $persona
     * @return UsuarioChat|null
     */
    public function getUsuarioChat(Persona $persona) : ?UsuarioChat
    {
        return $this->usuarioChatRepository->getUsuarioChatByPersona($persona);
    }

    /**
     * Devuelve usuario del chat dado persona
     *
     * @param User $user
     * @return UsuarioChat|null
     */
    public function getUsuarioChatPorUsuario(User $user) : ?UsuarioChat
    {
        return $this->usuarioChatRepository->getUsuarioChatByUsuario($user);
    }

    /**
     * Verifica si la persona tiene un usuario de chat ya
     *
     * @param Persona $persona
     * @return boolean
     */
    public function tieneUsuarioChat(Persona $persona) 
    {
        $userChat = $this->getUsuarioChat($persona);

        return (null != $userChat && null != $userChat->getChatId());
    }

    public function elminarUsuarioChat(Persona $persona)
    {
        $usuarioChat = $this->getUsuarioChat($persona);

        if(isset($usuarioChat))
        {
            $usuarioChat->setPersona(null);
            $usuarioChat = $this->usuarioChatRepository->edit($usuarioChat);
            
            try
            {
                $desactivate = $this->gatewayChatService->desactivateUser($usuarioChat->getChatId());

                if($desactivate) 
                {                
                    $this->usuarioChatRepository->remove($usuarioChat);
                }

            }
            catch(Exception $e)
            {
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * Verifica si la persona tiene un token access
     *
     * @param Persona $persona
     * @return boolean
     */
    public function tieneToken(Persona $persona) : bool
    {
        $userChat = $this->usuarioChatRepository->getUsuarioChatByPersona($persona);

        return (null != $userChat && null != $userChat->getToken());
    }


    /**
    * MYCHATSERVICE
    * Devuelve la cantidad de Mensajes si leer
    *
    * @return int
    */
    public function getUnreadMessages() : int
    {       
        try{
            $userChat = $this->gatewayChatService->getLoginChatUser();           

            if(!isset($userChat) || null == $userChat->getToken())
            {
                return 0;
            }

            $userId = $userChat->getId();
            $teamId = $userChat->getTeamId();

            return $this->gatewayChatService->getUnreadMessages($userId, $teamId);
        }       
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
            return 0;
        }
    }    

   
    public function getLastMessages($cant) : array
    {  
        try{
            $userChat = $this->gatewayChatService->getLoginChatUser();           

            if(!isset($userChat) || null == $userChat->getToken())
            {
                return array();
            }

            $userId = $userChat->getId();
            $teamId = $userChat->getTeamId();

            $cant = $cant / 2;
            $messages = $this->gatewayChatService->getLastMessages($userId, $teamId, $cant, $cant);
            
            foreach($messages as $k => &$m)
            {
                try
                {
                    $userChat = $this->usuarioChatRepository->getUsuarioChatByChatId($m->getUserId());
                    $name = isset($userChat) ? $userChat->getNickname() : 'Alguien';
                    $m->setName($name);
                }
                catch(Exception $e)
                {                    
                }
            }
            

            return $messages;
        }       
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
            
            return array();
        }
    }    
    
    /**
     * MYCHATSERVICE
     * Crea un usuario para el Chat si la person no tiene uno
     *
     * @param Persona $persona
     * @return void
     */
    public function crearUsuarioChat(Persona $persona, $password) 
    {
        try
        {
            if(!$this->tieneUsuarioChat($persona))
            {
                $user = $persona->getUsuario();                 

                if(null != $user)
                {
                    $nombreUsuario = $this->generarNombreUsuario($persona, $user);
                    $password = (null != $password) ? AlgPassEncrypt::encodePassowrd($password, $this->currentAlg) : AlgPassEncrypt::encodePassowrd(AlgPassEncrypt::generarPassword(), $this->currentAlg);
                    
                    //Creando modelo de chat user
                    $chatUser = new ChatUser();
                    $chatUser->setUsername($nombreUsuario);
                    $chatUser->setPassword($password);
                    $chatUser->setEmail($this->generarEmailUsuario($user->getEmail()));
                    $chatUser->setNickname($nombreUsuario);
                    $chatUser->setFirstName($persona->getPrimerNombre() . ((null != $persona->getSegundoNombre()) ? ' ' . $persona->getSegundoNombre() : ''));
                    $chatUser->setLastName($persona->getPrimerApellido() . ((null != $persona->getSegundoApellido()) ? ' ' . $persona->getSegundoApellido() : ''));

                    //Regitra por primera vez localmente el usuario del chat (for match)   
                    $usuarioChat = $this->getUsuarioChat($persona);                                         
                    if(null == $usuarioChat)
                    {
                        $usuarioChat = new UsuarioChat();
                        $usuarioChat->setPersona($persona);    
                        $usuarioChat->setUserchat($chatUser->getUsername());
                        $usuarioChat->setEmail($chatUser->getEmail());
                        $usuarioChat->setNickname($chatUser->getUsername());
                        $usuarioChat->setPassword($chatUser->getPassword());
                        $usuarioChat->setNombre($chatUser->getFirstName());
                        $usuarioChat->setApellido($chatUser->getLastName()); 
                        $usuarioChat->setActivo(false);
                        $usuarioChat->setError(null);
                        $usuarioChat = $this->usuarioChatRepository->add($usuarioChat);
                    }

                    //Registrado el usuario en Chat en el Sistema externo
                    $chatUser = $this->gatewayChatService->createUser($chatUser);
                    
                    //Actualiza localmente el usuario del chat (sucess match))
                    if(null != $chatUser && null != $chatUser->getId())
                    {                
                        $usuarioChat->setChatId($chatUser->getId());
                        $usuarioChat->setEmail($chatUser->getEmail());
                        $usuarioChat->setUserchat($chatUser->getUsername());
                        $usuarioChat->setNickname($chatUser->getNickname());
                        $usuarioChat->setNombre($chatUser->getFirstName());
                        $usuarioChat->setApellido($chatUser->getLastName());
                        $usuarioChat->setError(null);
                        $usuarioChat->setActivo(true);
                    }
                    //Actualiza error al crear usuario del chat (fail match))
                    else
                    {
                        $usuarioChat->setError($chatUser->getError());                    
                    }

                    $usuarioChat = $this->usuarioChatRepository->edit($usuarioChat);

                    //Creando el token para conectar a la api
                    $this->crearToken($usuarioChat);

                    //Adicionado el usuario al  Team por defecto
                    $this->adicionarUsuarioTeam($usuarioChat);

                    //Set Avatar
                    $this->setAvatar($persona);
                }
            }     
        }  
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
        }    
    }  

    /**
     * MYCHATSERVICE
     * Actualiza un usuario para el Chat si la person tiene uno
     *
     * @param Persona $persona
     * @return void
     */
    public function updateUsuarioChatParaPersona(Persona $persona) 
    {     
        try
        {            
            if($this->tieneUsuarioChat($persona))
            {            
                $usuarioChat = $this->getUsuarioChat($persona);            

                $user = $persona->getUsuario();                
                

                if(null != $user)
                {
                    $nombreUsuario = $this->generarNombreUsuario($persona, $user);
                    
                    //Creando modelo de chat user
                    $chatUser = new ChatUser();
                    $chatUser->setId($usuarioChat->getChatId());
                    $chatUser->setUsername($nombreUsuario);
                    $chatUser->setEmail($this->generarEmailUsuario($user->getEmail()));
                    $chatUser->setNickname($nombreUsuario);
                    $chatUser->setFirstName($persona->getPrimerNombre() . ((null != $persona->getSegundoNombre()) ? ' ' . $persona->getSegundoNombre() : ''));
                    $chatUser->setLastName($persona->getPrimerApellido() . ((null != $persona->getSegundoApellido()) ? ' ' . $persona->getSegundoApellido() : ''));

                    //Actualiza el usuario en Chat en el Sistema externo
                    $chatUser = $this->gatewayChatService->updateUser($usuarioChat->getChatId(), $chatUser);

                    
                    
                    //Actualiza localmente el usuario del chat (sucess match))
                    if(null != $chatUser && null != $chatUser->getId())
                    {   
                        $usuarioChat->setEmail($chatUser->getEmail());
                        $usuarioChat->setUserchat($chatUser->getUsername());
                        $usuarioChat->setNickname($chatUser->getNickname());
                        $usuarioChat->setNombre($chatUser->getFirstName());
                        $usuarioChat->setApellido($chatUser->getLastName());
                        $usuarioChat->setError(null);
                        $usuarioChat->setActivo(true);
                    }
                    //Actualiza error al actuazlizar usuario del chat (fail match))
                    else
                    {
                        $usuarioChat->setError($chatUser->getError());                    
                    }

                    $usuarioChat = $this->usuarioChatRepository->edit($usuarioChat);
                }
            } 
        }   
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
        }       
    }   
    
    /**
     * Crea y almacena un access token para el usuario si no tienen uno
     * Puede forrsarse a creat un nuevo token
     *
     * @param Persona $persona
     * @param boolean $force
     * @return void
     */
    public function crearTokenUsuarioChat(Persona $persona, $force = false)
    { 
        $usuarioChat = $this->getUsuarioChat($persona);        

        if(null != $usuarioChat)
        {
            if(null == $usuarioChat->getToken() || $force)
                $this->crearToken($usuarioChat);
        } 
    }

    /**
     * MYCHATSERVICE
     * Adiciona un usuario al Team por defecto
     *
     * @param UsuarioChat $usuarioChat
     * @return void
     */
    public function adicionarUsuarioTeam(UsuarioChat $usuarioChat)
    {
        try
        {
            $team = $this->gatewayChatService->addUserToDefaulTeam($usuarioChat->getChatId());

            if(null != $team)
            {
                $usuarioChat->setTeamdId($team->getId());
                $usuarioChat = $this->usuarioChatRepository->edit($usuarioChat);
            }
        }
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
        }
    }


    /**
     * MYCHATSERVICE
     * Actualiza la contrasena dado un nuevo password
     * Usa el ultimo password almacenado encriptado
     * 
     * @param [type] $newPassword
     * @return void
     */
    public function resetPasswordForLoginUser($newPassword)
    {
        try{
            $chatUser = $this->gatewayChatService->getLoginChatUser();

            if(isset($chatUser))
            {
                //Recuperando password antiguo guardado
                $oldPassword = AlgPassEncrypt::decodePassowrd($chatUser->getPassword(), $chatUser->getAlgPassEncrypt());

                //Tratando de cambiar el password en el Chat
                $chatUserResponse = $this->gatewayChatService->changeUserPassword($chatUser->getId(), $oldPassword, $newPassword);
            
                //Guardadno el nuevo password para un posterior cambio o el error al cambiar el password
                $persona = $this->personaRepository->find($chatUser->getMatchId());
                $usuarioChat = $this->getUsuarioChat($persona);
                $this->savePasswordForUsuarioChat($usuarioChat, $newPassword, $chatUserResponse->getError());
            }   
        }  
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
        }   
    }
    

    /**
     * MYCHATSERVICE
     * Sincroniza los datos de la Persona con el usuario Chat
     * 1- Crea el usuario nuevo del chat si no lo tiene (con la contrasena puesta por la administacion)
     * 2- Actualiza los datos del usuario si ya existe
     * 3- Crea un tonken nuevo para el chat
     *  
     * 
     * La  contrasena debe ser cambiada por el cambio de contrasena del usuario 
     * o por el Sistema Admin del Chat (en este caso ponerse de acuerdo con el usuario para ponerle la misma del sistema)
     *
     * @param Persona $persona
     * @return void
     */
    public function sincronizarUsuarioChat(UsuarioChat $usuarioChat)
    {
        try
        {
            //Tomando persona 
            $persona = $this->personaRepository->find($usuarioChat->getPersona());       

            //Si no es null (esto no debe suceder, ya que simpre quedan preparados)
            if(null != $usuarioChat)
            {            
                //Caso de que no se le creo usuario en el chat: Crear usuario con la contrasena actual del usuario
                if(null == $usuarioChat->getChatId())
                {
                    $this->crearUsuarioChat($persona, $usuarioChat->getPassword());
                }
                //Caso de que ya tiene su usuario en el chat: Se actualzia la persona
                else
                {                   
                    $this->updateUsuarioChatParaPersona($persona);
                    $this->crearToken($usuarioChat);
                    $this->adicionarUsuarioTeam($usuarioChat);
                    $this->setAvatar($persona);
                }
            }
            //Creando un usuario con una contrasena ramdon
            else
            {
                $this->crearUsuarioChat($persona, AlgPassEncrypt::generarPassword());
            }
        }
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     *  Imagen (avatar) for user
     *
     * @param [type] $persona
     * @return void
     */
    public function setAvatar(Persona $persona)
    {        
        if(isset($persona))
        {
            $usuarioChat = $this->getUsuarioChat($persona);            

            if(isset($usuarioChat) && null != $usuarioChat->getChatId())
            {
                if (file_exists('uploads/images/personas/' . $persona->getFoto())) 
                {
                    $resource = fopen('uploads/images/personas/' . $persona->getFoto(), 'rb');

                    if ($resource !== false) {

                        $data = new \GuzzleHttp\Psr7\Stream($resource);
            
                        $this->gatewayChatService->setAvatar($usuarioChat->getChatId(), $data);
                        fclose($resource);
                    }       
                }
            }
        }
    } 

    /**
     * Almacena el password del chat encriptado (reversible)
     *
     * @param UsuarioChat $usuarioChat
     * @param [type] $password
     * @return void
     */
    private function savePasswordForUsuarioChat(UsuarioChat $usuarioChat, $passwordTextPlain, $error)
    {        
        $encodePassword = AlgPassEncrypt::encodePassowrd($passwordTextPlain, $this->currentAlg);

        if(null == $error)
        {
            $usuarioChat->setPassword($encodePassword);
            $usuarioChat->setAlgPassEncrypt($this->currentAlg);
            $usuarioChat->setError(null);
        }
        else
        {
            $usuarioChat->setError($error . " ($passwordTextPlain)");
        }

        $usuarioChat = $this->usuarioChatRepository->edit($usuarioChat);  
    }


    private function crearToken(UsuarioChat $usuarioChat)
    { 
        $token = $this->gatewayChatService->createUserToken($usuarioChat->getChatId(), "Para Gboart. Uso de la api para el usuaraio logueado");
     
        if(null != $token)
        {
            $usuarioChat->setToken($token);
            $usuarioChat->setTokenFecha(new \DateTime());
            $usuarioChat = $this->usuarioChatRepository->edit($usuarioChat);  
        }
    }

    private function generarNombreUsuario(Persona $persona, User $user) : string
    {        
        $username = $user->getUsername();

        $userParts = explode("@", $username);

        $newuser = $userParts[0];

        $newuser = str_replace(' ', '', $newuser);

        return $newuser;
    }    

    private function generarEmailUsuario($email) : string
    {        
        $newemail = str_replace(' ', '', $email);

        return $newemail;
    } 
}
