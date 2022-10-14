<?php

namespace App\ExtendSys\Chat\Model;

/**
 * Admin User
 */
class ChatUser
{
    private $id;

    private $username;

    private $email;

    private $password;

    private $firstName;

    private $lastName;

    private $nickname;    

    private $error;

    private $teamName;

    private $teamId;
    
    private $token = null;

    //Define el algoritmo de encrypatcion usado
    private $algPassEncrypt;

    //Define el id de match con el sistema interno (idpersona, idusuario... etc)
    private $matchId;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

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
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

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
     * Get the value of teamName
     */ 
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * Set the value of teamName
     *
     * @return  self
     */ 
    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;

        return $this;
    }

    /**
     * Get the value of teamId
     */ 
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * Set the value of teamId
     *
     * @return  self
     */ 
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken() : ?string
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
     * Get the value of algPassEncrypt
     */ 
    public function getAlgPassEncrypt()
    {
        return $this->algPassEncrypt;
    }

    /**
     * Set the value of algPassEncrypt
     *
     * @return  self
     */ 
    public function setAlgPassEncrypt($algPassEncrypt)
    {
        $this->algPassEncrypt = $algPassEncrypt;

        return $this;
    }

    /**
     * Get the value of matchId
     */ 
    public function getMatchId()
    {
        return $this->matchId;
    }

    /**
     * Set the value of matchId
     *
     * @return  self
     */ 
    public function setMatchId($matchId)
    {
        $this->matchId = $matchId;

        return $this;
    }
}
