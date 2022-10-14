<?php

namespace App\ExtendSys\Chat\Mattermost;

use App\ExtendSys\Chat\ChatConnectInterface;
use App\ExtendSys\Chat\Model\ChannelInfo;

/**
 * Management Channels
 */
class Channels
{
    /**
     * Chanes for user in team
     *
     * @param ChatConnectInterface $chatConnectInterface
     * @param [type] $userId
     * @param [type] $teamId
     * @return array
     */
    public static function getChannels(ChatConnectInterface $chatConnectInterface, $userId, $teamId) : array
    {
        $driver = Connect::getConnection($chatConnectInterface->getUserConnect());

        $response =  $driver->getChannelModel()->getChannelsForUser($userId, $teamId);    
        
        $chanels = array();
        
        if (CheckResponse::checkStatus($response, 200)) {

            $obj = json_decode($response->getBody());              
           
            foreach($obj as $chanel)
            {                          
                $c = new ChannelInfo($chanel->id, $chanel->name, $chanel->type);

                $chanels[] = $c;
            }
        }

        return $chanels;
    }    
}