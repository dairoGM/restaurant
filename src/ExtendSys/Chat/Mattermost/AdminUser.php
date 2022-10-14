<?php

namespace App\ExtendSys\Chat\Mattermost;

use App\ExtendSys\Chat\ChatConnectInterface;
use App\ExtendSys\Chat\Model\ChatUser;
use Exception;

/**
 * Admin User
 */
class AdminUser
{ 
    public static function desactivateUser(ChatConnectInterface $chatConnectInterface, $chatId) : bool
    {
        try
        {
            $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());
            
            $response = $driver->getUserModel()->deactivateUserAccount($chatId);

            if (CheckResponse::checkStatus($response, 200))
            {
                return true;
            }
        }
        catch(Exception $e)
        {
            return false;
        }

        return false;
    }
    
    /**
     * Create user for chat
     *
     * @param ChatConnectInterface $chatConnectInterface
     * @param ChatUser $chatUserIn
     * @return ChatUser|null
     */
    public static function createUser(ChatConnectInterface $chatConnectInterface, ChatUser $chatUserIn) : ?ChatUser
    {      
        try{
            $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());
            $chatUserOut = new ChatUser();

            $response = $driver->getUserModel()->createUser([
                "username" => $chatUserIn->getUsername(),
                "email" => $chatUserIn->getEmail(),
                "password" => $chatUserIn->getPassword(),
                "first_name"=> $chatUserIn->getFirstName(),
                "last_name"=> $chatUserIn->getLastName(),
                "nickname" => $chatUserIn->getNickname(),
            ]);
            
            if (CheckResponse::checkStatus($response, 200, 201)) {

                $obj = json_decode($response->getBody());
            
                $chatUserOut->setId($obj->id);
                $chatUserOut->setUsername($obj->username);
                $chatUserOut->setEmail($obj->email);
                $chatUserOut->setNickname($obj->nickname);
                $chatUserOut->setFirstName($obj->first_name);
                $chatUserOut->setLastName($obj->last_name);

                return $chatUserOut;
            }
            else{
                $error = CheckResponse::getErrorMessage($response);
                $chatUserOut->setError($error);
            }
        }
        catch(Exception $e)
        {
            $error = $e->getMessage();
            $chatUserOut->setError($error);
        }

        return $chatUserOut;
    }    

    /**
     * Create user token for user chat
     *
     * @param ChatConnectInterface $chatConnectInterface
     * @param [type] $userId User chat id
     * @return string|null
     */
    public static function createUserToken(ChatConnectInterface $chatConnectInterface, $userId, $decription) : ?string
    {
        $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());
       
        $response = $driver->getUserModel()->createToken(
            $userId, 
            [
                "description" => $decription,
            ]
        );
        

        if (CheckResponse::checkStatus($response, 200, 201)) {
            $obj = json_decode($response->getBody()); 
            
            if(is_array($obj))
            {
                $obj = $obj[0];
            }
            
            return $obj->token;
        }

        return null;
    }


    /**
     * Update user for chat
     *
     * @param ChatConnectInterface $chatConnectInterface
     * @param ChatUser $chatUserIn
     * @return ChatUser|null
     */
    public static function updateUser(ChatConnectInterface $chatConnectInterface, $userId, ChatUser $chatUserIn) : ?ChatUser
    {
        $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());
        $chatUserOut = new ChatUser();

        $response = $driver->getUserModel()->patchUser($userId, [
            "username" => $chatUserIn->getUsername(),
            "email" => $chatUserIn->getEmail(),            
            "first_name"=> $chatUserIn->getFirstName(),
            "last_name"=> $chatUserIn->getLastName(),
            "nickname" => $chatUserIn->getNickname(),
        ]);
        
        if (CheckResponse::checkStatus($response, 200, 201)) {

            $obj = json_decode($response->getBody());
           
            $chatUserOut->setId($obj->id);
            $chatUserOut->setUsername($obj->username);
            $chatUserOut->setEmail($obj->email);
            $chatUserOut->setNickname($obj->nickname);
            $chatUserOut->setFirstName($obj->first_name);
            $chatUserOut->setLastName($obj->last_name);

            return $chatUserOut;
        }
        else{
            $error = CheckResponse::getErrorMessage($response);
            $chatUserOut->setError($error);
        }

        return $chatUserOut;
    }    
}