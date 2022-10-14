<?php

namespace App\ExtendSys\Chat\Model;

class ConInfo
{
    private bool $success;

    private string $info;

    private string $description;

    private string $urlChat;

    public function __construct($success, $urlChat, $info, $description)
    {
        $this->success = $success;
        $this->urlChat = $urlChat;
        $this->info = $info;
        $this->description = $description;
    }

    /**
     * Get the value of success
     */ 
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Get the value of info
     */ 
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of urlChat
     */ 
    public function getUrlChat()
    {
        return $this->urlChat;
    }
}