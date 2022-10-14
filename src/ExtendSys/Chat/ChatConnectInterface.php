<?php

namespace App\ExtendSys\Chat;

use App\ExtendSys\Chat\Model\ChatUser;

/**
 * Interface for Chat
 */
interface ChatConnectInterface
{
    /**
     * Retorna la Config para conexión para Admnistrar
     *
     * @return ConnectConfig
     */
    function getAdminConnect() : ConnectConfig;

    /**
     * Retorna la Config para conexión de un usuario específico
     *
     * @return ConnectConfig
     */
    function getUserConnect() : ConnectConfig;    

    /**
     * Devuelve el usuario actual logueado
     *
     * @return ChatUser
     */
    function getLoginChatUser() : ?ChatUser;
}