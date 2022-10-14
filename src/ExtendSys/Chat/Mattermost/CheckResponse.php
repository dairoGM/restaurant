<?php

namespace App\ExtendSys\Chat\Mattermost;

use Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * CheckResponse
 */
class CheckResponse
{ 
    public static function checkStatus(ResponseInterface $response, ...$statusesCodes) : bool
    {
        $statusCode = $response->getStatusCode();

        foreach($statusesCodes as $s)
        {
            if($s == $statusCode){
                return true;
            }
        }
        
        return false;
    }

    public static function getErrorMessage(ResponseInterface $response) : string
    {
        $error = $response->getBody()->getContents();

        try
        {
            $obj = json_decode($error);

            if(isset($obj) && isset($obj->message))
            {
                return $obj->message; 
            }

            if(is_string($error))
            {
                return $error;
            }
        }
        catch(Exception $e)
        {           
        }

        return "Error desconocido";
    }
}