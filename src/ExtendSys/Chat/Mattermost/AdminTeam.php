<?php

namespace App\ExtendSys\Chat\Mattermost;

use App\ExtendSys\Chat\ChatConnectInterface;
use App\ExtendSys\Chat\Model\ChatUser;
use App\ExtendSys\Chat\Model\Team;

/**
 * Admin Team
 */
class AdminTeam
{ 
    
    public static function getTeamByName(ChatConnectInterface $chatConnectInterface, $teamName) : ?Team
    {
        $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());
        
        return AdminTeam::getTeamByNameForDriver($driver, $teamName);
    }

    /**
     * Add User to Team
     *
     * @param ChatConnectInterface $chatConnectInterface
     * @param [type] $teamId
     * @param [type] $userId
     * @return Team
     */
    public static function addUserToTeam(ChatConnectInterface $chatConnectInterface, $teamName, $userId) : ?Team
    {
        $driver = Connect::getConnection($chatConnectInterface->getAdminConnect());

        $team = AdminTeam::getTeamByNameForDriver($driver, $teamName);

        if(null != $team)
        {
            $response = $driver->getTeamModel()->addUser(
                $team->getId(), 
                [
                    "user_id" => $userId,
                    "team_id" => $team->getId()         
                ]
            );
            
            if (CheckResponse::checkStatus($response, 200, 201)) {

                $obj = json_decode($response->getBody());
            
                $team = new Team();
                $team->setId($obj->team_id);
                $team->setName($teamName);

                return $team;
            }
        }

        return null;
    } 

    private static function getTeamByNameForDriver($driver, $teamName) : ?Team
    {
        $response = $driver->getTeamModel()->getTeamByName($teamName);

        if (CheckResponse::checkStatus($response, 200, 201)) {

            $obj = json_decode($response->getBody());
           
            $team = new Team();
            $team->setId($obj->id);
            $team->setName($obj->name);

            return $team;
        }

        return null;
    }
}