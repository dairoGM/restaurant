<?php

namespace App\Entity\Security;

use App\Entity\BaseEntity;
use App\Entity\Personal\Persona;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Usuario del Chat (Usuario que se prepara para machar con el usuario del chat)
 * @ORM\Entity
 * @UniqueEntity(fields="chatId", message="chat id repetido {{ value }}.")
 * @UniqueEntity(fields="userchat", message="El usuario del chat {{ value }} ya está siendo usado.")
 * @UniqueEntity(fields="email", message="El correo del chat {{ value }} ya está siendo usado.")
 * @UniqueEntity(fields="nickname", message="El nick del chat {{ value }} ya está siendo usado.")
 * @ORM\Table(name="seguridad.tbd_usario_chat")
 */
class UsuarioChat extends BaseEntity
{
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personal\Persona")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Persona $persona = null;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $chatId = null;

     /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private $userchat;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private $nickname; 

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $password;   

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $token = null; 

    /** 
     * @ORM\Column(type="datetime", nullable=true)
     */  
    private $tokenFecha = null; 
    
    /**
     * @ORM\Column(type="string", length=180, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=180, nullable=false)
     */
    private $apellido;  

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private ?bool $activo = true;

    /** 
     * @ORM\Column(type="datetime", nullable=true)
    */  
    private $ultimaEntrada = null; 

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $error = null;

    /**
     * Team por defecto asociado al usuario
     * @ORM\Column(type="string", nullable=true)
     */
    private $teamdId = null;

    /**
     * Define el algoritmo de encrypatcion usado     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $algPassEncrypt;


    /**
     * Get the value of persona
     */ 
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set the value of persona
     *
     * @return  self
     */ 
    public function setPersona($persona)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get the value of chatId
     */ 
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * Set the value of chatId
     *
     * @return  self
     */ 
    public function setChatId($chatId)
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * Get the value of userchat
     */ 
    public function getUserchat()
    {
        return $this->userchat;
    }

    /**
     * Set the value of userchat
     *
     * @return  self
     */ 
    public function setUserchat($userchat)
    {
        $this->userchat = $userchat;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of nickname
     */ 
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set the value of nickname
     *
     * @return  self
     */ 
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of tokenFecha
     */ 
    public function getTokenFecha()
    {
        return $this->tokenFecha;
    }

    /**
     * Set the value of tokenFecha
     *
     * @return  self
     */ 
    public function setTokenFecha($tokenFecha)
    {
        $this->tokenFecha = $tokenFecha;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of activo
     */ 
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of activo
     *
     * @return  self
     */ 
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get the value of apellido
     */ 
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set the value of apellido
     *
     * @return  self
     */ 
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get the value of ultimaEntrada
     */ 
    public function getUltimaEntrada()
    {
        return $this->ultimaEntrada;
    }

    /**
     * Set the value of ultimaEntrada
     *
     * @return  self
     */ 
    public function setUltimaEntrada($ultimaEntrada)
    {
        $this->ultimaEntrada = $ultimaEntrada;

        return $this;
    }

    /**
     * Get the value of error
     */ 
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the value of error
     *
     * @return  self
     */ 
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get team por defecto asociado al usuario
     */ 
    public function getTeamdId()
    {
        return $this->teamdId;
    }

    /**
     * Set team por defecto asociado al usuario
     *
     * @return  self
     */ 
    public function setTeamdId($teamdId)
    {
        $this->teamdId = $teamdId;

        return $this;
    }

    /**
     * Get define el algoritmo de encrypatcion usado
     */ 
    public function getAlgPassEncrypt()
    {
        return $this->algPassEncrypt;
    }

    /**
     * Set define el algoritmo de encrypatcion usado
     *
     * @return  self
     */ 
    public function setAlgPassEncrypt($algPassEncrypt)
    {
        $this->algPassEncrypt = $algPassEncrypt;

        return $this;
    }
}
