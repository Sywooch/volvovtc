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
        //$id = '861317'; // for test purposes

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

    private function requestPlayer($id){
        return json_decode(file_get_contents('https://api.truckersmp.com/v2/player/'.$id));
    }

    private function requestBans($id){
        return json_decode(file_get_contents('https://api.ets2mp.com/bans/'.$id));
    }

}