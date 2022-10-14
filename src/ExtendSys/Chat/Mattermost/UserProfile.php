<?php

namespace App\ExtendSys\Chat\Mattermost;

use App\ExtendSys\Chat\ChatConnectInterface;
use App\ExtendSys\Chat\Model\ChatUser;
use Exception;

/**
 * User Profile
 */
class UserProfile
{    

    /**
     * Change user password
     *
     * @param ChatConnectInterface $chatConnectInterface
     * @param [type] $userId
     * @param [type] $currentPassword
     * @param [type] $newPassword
     * @return ChatUser
     */
    public static function updatePassword(ChatConnectInterface $chatConnectInterface, $userId, $currentPassword, $newPassword) : ChatUser
    {
        try{
            $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());

            $response = $driver->getUserModel()->updateUserPassword($userId, 
                [
                "current_password" => $currentPassword,
                "new_password" => $newPassword
            ]);

            $chatUser = new ChatUser();       
            $chatUser->setId($userId);

            if (CheckResponse::checkStatus($response, 200)) {

                $chatUser->setPassword($newPassword);
                $chatUser->setError(null);
            }
            else{            
                $error = CheckResponse::getErrorMessage($response);
                $chatUser->setPassword($currentPassword);
                $chatUser->setError($error);
            }
        }
        catch(Exception $e)
        {
            $error = $e->getMessage();
            $chatUser->setPassword($currentPassword);
            $chatUser->setError($error);
        }

        return $chatUser;
    }

    /**
     * Imagen (avatar) for user
     *
     * @param ChatConnectInterface $chatConnectInterface
     * @param [type] $userId
     * @param [string <binary> ] $imageData
     * @return void
     */
    public static function setAvatar(ChatConnectInterface $chatConnectInterface, $userId, $imageData)     
    {
        if(null != $imageData)
        {
            $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());

            $response = $driver->getUserModel()->setUserProfileImage($userId, 
                [
                "image" => $imageData
            ]);
        }
    }
}