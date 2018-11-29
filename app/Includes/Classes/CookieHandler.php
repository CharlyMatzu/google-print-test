<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 28/11/2018
 * Time: 05:39 AM
 */

namespace App\Includes\Classes;


class CookieHandler
{
    const EXPIRATION = 60 * 60 * 24 * 7 * 12;
    const NAME = 'PRINTSESSION';
    const PATH = '/';

    public static function makeSessionCookie($userId){
        setcookie(self::NAME, $userId, time() + self::EXPIRATION, self::PATH );
    }

    /**
     * @return bool
     */
    public static function getCookieData(){
        if( !isset($_COOKIE[self::NAME]) )
            return false;
        else
            return $_COOKIE[self::NAME];
    }

    public static function removeCookie(){
//        $id = $_COOKIE[self::NAME];
        setcookie(self::NAME, '', time()  -10, self::PATH );
    }
}