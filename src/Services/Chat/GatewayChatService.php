<?php

namespace App\Services\Chat;

use App\ExtendSys\Chat\GatewayChatInterface;
use App\ExtendSys\Chat\Mattermost\AdminTeam;
use App\ExtendSys\Chat\Mattermost\AdminUser;
use App\ExtendSys\Chat\Mattermost\Connect;
use App\ExtendSys\Chat\Mattermost\Messages;
use App\ExtendSys\Chat\Mattermost\UserProfile;
use App\ExtendSys\Chat\Model\ChatUser;
use App\ExtendSys\Chat\Model\ConInfo;
use App\ExtendSys\Chat\Model\Team;

/** 
 * Servicio del Chat 
 */
class GatewayChatService implements GatewayChatInterface
{
    private ChatConnectService $chatConnectService;

    public function __construct(ChatConnectService $chatConnectService)
    {       
        $this->chatConnectService = $chatConnectService; 
    }



    /**
     * Devuelve el usuario actual logueado
     *
     * @return ChatUser
     */
    function getLoginChatUser() : ?ChatUser
    {
        return $this->chatConnectService->getLoginChatUser();
    }

    /**
     * Devuelve el estado de la conexion
     *
     * @return ConInfo
     */
    public function  testConnection() : ConInfo
    {
        return Connect::testConnection($this->chatConnectService->getAdminConnect());
    }

    /**
     * Retunrs cant unread messages
     *
     * @param [type] $userId
     * @param [type] $teamId
     * @return integer
     */
    public function getUnreadMessages($userId, $teamId) : int
    {       
        return Messages::getUnreadMessages($this->chatConnectService, $userId, $teamId);       
    }  
    
    /**
     * Create user token for user chat
     *
     * @param ChatUser $chatUser
     * @return ChatUser|null
     */
    function createUser(ChatUser $chatUser) : ?ChatUser
    {
        return AdminUser::createUser($this->chatConnectService, $chatUser);
    }

    /**
     * Desactiva un usuario
     *
     * @param [type] $chatUserId
     * @return bool
     */
    function desactivateUser($chatUserId) : bool
    {
        return AdminUser::desactivateUser($this->chatConnectService, $chatUserId);
    }

    /**
     * Update user for chat
     *
     * @param ChatUser $chatUser
     * @return ChatUser|null
     */
    function updateUser($userId, ChatUser $chatUser) : ?ChatUser
    {
        return AdminUser::updateUser($this->chatConnectService, $userId, $chatUser);
    }

    /**
     * Create and returns user token
     *
     * @return string|null
     */
    function createUserToken($userId, $decription) : ?string
    {
        return AdminUser::createUserToken($this->chatConnectService,$userId, $decription);
    }

    /**
     * Add User to Team
     *     
     * @param [type] $teamId
     * @param [type] $userId
     * @return Team
     */
    function addUserToTeam($teamName, $userId) : ?Team
    {
        return AdminTeam::addUserToTeam($this->chatConnectService, $teamName, $userId);
    }

     /**
     * Add User to Default Team     
     *       
     * @param [type] $userId
     * @return Team
     */
    function addUserToDefaulTeam($userId) : ?Team
    {
        return AdminTeam::addUserToTeam($this->chatConnectService, $this->chatConnectService->getDefaultTeamName(), $userId);
    }

    /**
     * Change user password
     *
     * @param [type] $userId
     * @param [type] $currentPassword
     * @param [type] $newPassword
     * @return ChatUser
     */
    function changeUserPassword($userId, $currentPassword, $newPassword) : ChatUser
    {
        return UserProfile::updatePassword($this->chatConnectService, $userId, $currentPassword, $newPassword);
    }

    /**
     *  Imagen (avatar) for user
     *
     * @param [type] $userId
     * @param [type] $imageData
     * @return void
     */
    function setAvatar($userId, $imageData)
    {
        return UserProfile::setAvatar($this->chatConnectService, $userId, $imageData);
    }

    function getLastMessages($userId, $teamId, $qtBefore, $qrAfter)
    {
        return Messages::getLastMessages($this->chatConnectService, $userId, $teamId, $qtBefore, $qrAfter);   
    }
}
