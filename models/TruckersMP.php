<?php

namespace app\models;


class TruckersMP{

    public static function getUserID($steamid){
        $json = self::requestPlayer($steamid);
        return $json->response->id;
    }

    public static function isMemberBanned($truckersmp){
        $banned = false;

        $id = explode('/', $truckersmp)[4]; // convert url to numeric id

        $bans = self::requestBans($id);
        foreach ($bans->response as $ban){
            $expiration = new \DateTime($ban->expiration);
            $now = new \DateTime();
            if($expiration > $now){
                $banned = true;
                break;
            }
        }

        return $banned;
    }

    public static function getMemberTruckersMpNickname($steamid){
        $json = self::requestPlayer($steamid);
        if(!$json->error){
            return $json->response->name;
        }else{
            return false;
        }
    }

    public static function getServersList(){
        $servers = self::getServersInfo();
        $servers_list = array();
        foreach($servers->response as $server){
            $servers_list[$server->game][$server->shortname . '_' . $server->game] = $server->name;
        }
        return $servers_list;
    }

    public static function getServerName($short){
        $servers = self::getServersInfo();
        $name = null;
        foreach($servers->response as $server){
            if($server->shortname.'_'.$server->game == $short){
                $name = $server->name;
            }
        }
        return $name;
    }

    private function requestPlayer($id){
        return json_decode(file_get_contents('https://api.truckersmp.com/v2/player/'.$id));
    }

    private function requestBans($id){
        return json_decode(file_get_contents('https://api.ets2mp.com/bans/'.$id));
    }

    private static function getServersInfo(){
        return json_decode(file_get_contents('https://api.truckersmp.com/v2/servers'));
    }

}