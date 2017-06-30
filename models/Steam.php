<?php

namespace app\models;


class Steam{

    public static $key = 'D5DE081206F0F2212E331852DC3CEC83';

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

}