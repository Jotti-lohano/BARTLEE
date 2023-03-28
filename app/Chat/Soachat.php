<?php

namespace App\Chat;

class Soachat
{
    /*  Declearing The static variables */
    /*  Enter the your app id you obtained while registration */
    /*  Enter the your secret_key you obtained while registration */
    /*  Never show or reveal your secret_key */

    static $app_id = '63b5aeae6f9efdd2fb25b02206e7983a';
    static $secret_key = '$2y$10$lvTnTQ78ywyQ1SJ7NPd88uQ9LWIZgBUB0iioUUsp.K6EwXAOjleXK';
    static $endpoint = 'http://dev28.onlinetestingserver.com/soachatapi';
    
    
    /* A curl Helper to perform HTTP POST */
    public static function request($fields, $url=''){
        $headers = array (
                "Connection: keep-alive",
                "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19",
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Encoding: gzip,deflate,sdch",
                "Accept-Language: en-US,en;q=0.8",
                "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3" 
        );
        $fields_string = http_build_query ( $fields );
        $cookie = 'cf6c650fc5361e46b4e6b7d5918692cd=49d369a493e3088837720400c8dba3fa; __utma=148531883.862638000.1335434431.1335434431.1335434431.1; __utmc=148531883; __utmz=148531883.1335434431.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); mcs=698afe33a415257006ed24d33c7d467d; style=default';
       
        $data_string = json_encode($fields);

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                         'Content-Type: application/json',
                         'Content-Length: ' . strlen($data_string))
        );
        $response = curl_exec ( $ch );
        curl_close ( $ch );
        return $response;
    } 
    
    /*  Endpoint to add User to Soachat system database POST - /api/user/add */
    public static function addUser($id,$name,$avatar=null,$isVideoIncluded=0){

        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'id' =>  $id,
            'name' =>  $name,
            'isVideoIncluded' => $isVideoIncluded,
            'avatar' =>  $avatar,
        );
        $url = self::$endpoint . '/api/user/add';
        $response = self::request($data, $url );
        return $response;
    }

    /*  Endpoint to add User in bulk to Soachat system database POST - /api/user/add */
    public function addUsersBulk($users=[]){
        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'user' =>  $users,
        );
        $url = self::$endpoint . '/api/user/bulk-add';
        $response = self::request($data, $url );
        return $response;
    }

    
    /*  Endpoint to update User to Soachat system database POST - /api/user/update */
    public static function updateUser($id,$name,$avatar=null,$isVideoIncluded=0){

        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'id' =>  $id,
            'name' =>  $name,
            'isVideoIncluded' => $isVideoIncluded,
            'avatar' =>  $avatar,
        );
        $url = self::$endpoint . '/api/user/update';
        $response = self::request($data, $url );
        return $response;
    }
    
    /*  Endpoint to delete User from Soachat system database POST - /api/user/remove */
    public static function removeUser($id){

        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'id' =>  $id,
        );
        $url = self::$endpoint . '/api/user/remove';
        $response = self::request($data, $url );
        return $response;
    }
    
    /*  Endpoint to retrieve User from Soachat system database POST - /api/user/remove */
    public static function reviveUser($id){

        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'id' =>  $id,
        );
        $url = self::$endpoint . '/api/user/revive';
        $response = self::request($data, $url );
        return $response;
    }
    
    /*  Endpoint to add User friends to Soachat system database POST - /api/user/add-friends */

    public static function addFriendsBulk($friends = []){
        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'friend' => $friends,
            // 'fromid' =>  $fromid,
            // 'toid' =>  $toid,
        );
        $url = self::$endpoint . '/api/user/add-friends-bulk';
        $response = self::request($data, $url );
        return $response;
    }


    public static function addFriends($fromid,$toid){
        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'fromid' =>  $fromid,
            'toid' =>  $toid,
        );
        $url = self::$endpoint . '/api/user/add-friends';
        $response = self::request($data, $url );
        return $response;
    }
    
    
    /*  Endpoint to remove User friends from Soachat system database POST - /api/user/remove-friends */
    public static function removeFriends($fromid,$toid){

        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'fromid' =>  $fromid,
            'toid' =>  $toid,
        );
        $url = self::$endpoint . '/api/user/remove-friends';
        $response = self::request($data, $url );
        return $response;
    }

    public static function login($id)
    {
        $data = array(
            'appid' =>  self::$app_id,
            'secret_key' =>  self::$secret_key,
            'id' =>  $id
        );
        $url = self::$endpoint . '/api/login';
        $response = self::request($data, $url );
        return $response;
    }



}    