<?php

namespace App\ExtendSys\Chat;

use App\ExtendSys\Chat\Model\ChatUser;
use App\ExtendSys\Chat\Model\ConInfo;
use App\ExtendSys\Chat\Model\Team;

/**
 * Interface for Chat
 */
interface GatewayChatInterface
{    
    /**
     * Devuelve el estado de la conexion
     *
     * @return ConInfo
     */
    function  testConnection() : ConInfo; 

    /**
     * Devuelve el usuario actual logueado
     *
     * @return ChatUser
     */
    function getLoginChatUser() : ?ChatUser;
    
    /**
     * Update user for chat
     *
     * @return ChatUser
     */
    function createUser(ChatUser $chatUser) : ?ChatUser;

    /**
     * Desactiva un usuario
     *
     * @param [type] $chatUserId
     * @return bool
     */
    function desactivateUser($chatUserId) : bool;
    

    /**
     * Change user password
     *
     * @return ChatUser
     */
    function changeUserPassword($userId, $currentPassword, $newPassword) : ChatUser;

    /**
     * Create user for chat
     *
     * @return ChatUser
     */
    function updateUser($userId, ChatUser $chatUser) : ?ChatUser;

    /**
     * Create and returns user token
     *
     * @return string|null
     */
    function createUserToken($userId, $decription) : ?string;

    /**
     * Retunrs cant unread messages
     *
     * @return int
     */
    function getUnreadMessages($userId, $teamId) : int;

    /**
     * Add User to Team
     *
     * @param [type] $teamName
     * @param [type] $userId
     * @return Team|null
     */
    function addUserToTeam($teamName, $userId) : ?Team;

    /**
     *  Imagen (avatar) for user
     *
     * @param [type] $userId
     * @param [type] $imageData
     * @return void
     */
    function setAvatar($userId, $imageData);
   
    function getLastMessages($userId, $teamId, $qtBefore, $qrAfter);
}