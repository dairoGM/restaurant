<?php

namespace App\ExtendSys\Chat\Mattermost;

use App\ExtendSys\Chat\ChatConnectInterface;
use App\ExtendSys\Chat\Model\MessagesInfo;
use Exception;

/**
 * Management Messages
 */
class Messages
{
    public static function getUnreadMessages(ChatConnectInterface $chatConnectInterface, $userId, $teamId) : int
    {
        $driver = Connect::getConnection($chatConnectInterface->getUserConnect());

        $cant = 0;

        $chanels = Channels::getChannels($chatConnectInterface, $userId, $teamId);

        foreach($chanels as $chanel)
        {
            $response = $driver->getChannelModel()->getUnreadMessages($userId, $chanel->getId());
    
            if (CheckResponse::checkStatus($response, 200)) {
    
                $obj = json_decode($response->getBody()); 
                                
                $cant += $obj->msg_count;
            }
        }

        return $cant;
    }

    public static function getLastMessages(ChatConnectInterface $chatConnectInterface, $userId, $teamId, $qtBefore, $qrAfter) : array
    {
        $driver = Connect::getConnection($chatConnectInterface->getUserConnect());     

        $messages = array();

        $chanels = Channels::getChannels($chatConnectInterface, $userId, $teamId);

        foreach($chanels as $chanel)
        {
            $response = $driver->getPostModel()->getPostsAroundLastUnread($userId, $chanel->getId(), [
                "limit_before" => $qtBefore,
                "limit_after" => $qrAfter,            
                "skipFetchThreads"=> true,
                "skipFetchThreads"=> true        ]
            );
    
            if (CheckResponse::checkStatus($response, 200)) {
    
                $obj = json_decode($response->getBody()); 
                                
                foreach($obj->posts as $msg)
                {                   
                    if($msg->message != "")
                    {
                        $m = new MessagesInfo(
                            $msg->id,
                            $msg->message,
                            $msg->user_id,
                            $msg->channel_id,
                            $msg->create_at
                        );

                        $messages[] = $m;
                    }
                }                  
            }
        }

        usort($messages, function($a, $b) {return strcmp($b->getCreate(), $a->getCreate());});     
        
        return array_slice($messages, 0, $qtBefore+$qrAfter);
    }    
}