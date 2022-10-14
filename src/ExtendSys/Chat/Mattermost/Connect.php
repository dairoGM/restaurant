<?php

namespace App\ExtendSys\Chat\Mattermost;


use App\ExtendSys\Chat\ConnectConfig;
use App\ExtendSys\Chat\Model\ConInfo;
use Exception;

use function PHPUnit\Framework\throwException;

/**
 * Admin User
 */
class Connect
{
    
    static public function testConnection(ConnectConfig $connectConfig) : ConInfo
    {
        $container = new \Pimple\Container([
            'driver' => [
                'scheme' => $connectConfig->getSchema(),
                'url' => $connectConfig->getUrl(),
                'token' => $connectConfig->getToken()
            ]
        ]);
        
        $driver = new DriverExt($container);
       
        try{
            $driver->authenticate(); 
        

            $response = $driver->getTeamModel()->getTeams([
                "page" => 0,
                "per_page" => 1
            ]);

            if (!CheckResponse::checkStatus($response, 200))
            {              
                throw new Exception(CheckResponse::getErrorMessage($response));
            }
        }
        catch(Exception $e)
        {
            return new ConInfo(false, $connectConfig->getSchema() . '://' . $connectConfig->getUrl(),  "Error de de conexión ", $e->getMessage());
        }        

        return new ConInfo(true, $connectConfig->getSchema() . '://'. $connectConfig->getUrl(), "Conexión satisfactoria", "La conexión se ha podido establecer correctamente");
    }

    static public function getConnection(ConnectConfig $connectConfig) : DriverExt
    {
        $container = new \Pimple\Container([
            'driver' => [
                'scheme' => $connectConfig->getSchema(),
                'url' => $connectConfig->getUrl(),
                'token' => $connectConfig->getToken()
            ]
        ]);
        
        $driver = new DriverExt($container);
       
        try{
            $driver->authenticate();
        }
        catch(Exception $e)
        {
            //Log
        }        

        return $driver;
    }   

    static public function userPasswordConnection(ConnectConfig $connectConfig, $user, $pass) : DriverExt
    {
        $container = new \Pimple\Container([
            'driver' => [
                'scheme' => $connectConfig->getSchema(),
                'url' => $connectConfig->getUrl(),
                'login_id' => $user,
                'password' => $pass,
                'token' => null,
            ]
        ]);
        
        $driver = new DriverExt($container);
        try{
            $driver->authenticate();
        }
        catch(Exception $e)
        {
            //Log
        }   

        return $driver;
    }
}
