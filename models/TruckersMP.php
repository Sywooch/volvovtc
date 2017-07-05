<?php

namespace app\models;


class TruckersMP{

    public static function getUserID($steamid){
        $json = json_decode(file_get_contents('https://api.truckersmp.com/v2/player/'.$steamid));
        return $json->response->id;
    }

    public static function isMemberBanned($truckersmp){
        $banned = false;

        $id = explode('/', $truckersmp)[4]; // convert url to numeric id
        //$id = '861317'; // for test purposes

        $bans = json_decode(file_get_contents('https://api.ets2mp.com/bans/'.$id));
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

}