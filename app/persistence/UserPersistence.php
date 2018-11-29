<?php namespace App\Persistence;


use App\Includes\Exceptions\PersistenceException;

class UserPersistence extends Persistence {


    /**
     * @param $user String
     * @param $pass String
     * @return array
     * @throws PersistenceException
     */
    public static function signIn($user, $pass){
        $ePass = md5($pass);
        $query = "SELECT * 
                  FROM user 
                  WHERE username = '$user' AND password = '$ePass'";
        $src = self::makeQuery($query);
        return self::fetchFirst( $src );
    }

    /**
     * @param $user
     * @param $pass
     * @return bool|
     * @throws PersistenceException
     */
    public static function signUp($user, $pass){
        $query = "INSERT INTO user(username, password) VALUES ('$user', '".md5($pass)."')";
        return self::makeQuery($query);
    }

    /**
     * @return array
     * @throws PersistenceException
     */
    public static function getAll(){
        $query = "SELECT * FROM user";
        $src = self::makeQuery($query);
        return self::fetchAll( $src );
    }

    /**
     * @param $userId int User id to search
     * @return array
     * @throws PersistenceException
     */
    public static function getUser_byId($userId){
        $query = "SELECT * FROM user
                  WHERE user_id = $userId";
        $src = self::makeQuery($query);
        return self::fetchFirst( $src );
    }

}