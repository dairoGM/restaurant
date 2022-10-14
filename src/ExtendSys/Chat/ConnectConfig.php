<?php

namespace App\ExtendSys\Chat;

/**
 * Admin User
 */
class ConnectConfig
{
    private $schema;

    private $url;

    private $token = null;

    function __construct($schema, $url, $token)
    {
        $this->schema = $schema;
        $this->url = $url;
        $this->token = $token;
    }

    function  getSchema() : string
    {
        return $this->schema;
    }
    
    function getUrl() : string
    {
        return $this->url;
    }

    function getToken() : ?string
    {
        return $this->token;
    }
}