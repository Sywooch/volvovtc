<?php

namespace app\models;


class Steam{

    private static $key = '4B20D16FDEF836EB866804F847F585A3';

    public static function getUser64ID($url){
        $url = str_replace(['http://', 'https://'], '', $url);
        $url = explode('/', $url);
        if (!preg_match('/^7656119[0-9]{10}$/i', $url[2])){
            $json = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key='.self::$key.'&vanityurl='.$url[2]));
            return $json->response->steamid;
        }else{
            return $url[2];
        }
    }

    public static function getPlayerNickname($steamid){
        $json = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.self::$key.'&steamids='.$steamid));
        if(count($json->response->players) > 0){
            return $json->response->players[0]->personaname;
        }else{
            return false;
        }
    }

}