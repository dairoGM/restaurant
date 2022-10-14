<?php

namespace App\ExtendSys\Chat\Model;

/**
 * Admin User
 */
class MessagesInfo
{
    private string $id;

    private string $create;

    private string $userId;

    private string $channelId;

    private string $message;

    private string $name;

    public function __construct($id, $message, $userId, $channelId, $create)
    {
       $this->id = $id;
       $this->message = $message;
       $this->userId = $userId;
       $this->channelId = $channelId;
       $this->create = $create;
       $this->name = 'Alguien';
    }

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of create
     */ 
    public function getCreate()
    {
        return $this->create;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get the value of channelId
     */ 
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
