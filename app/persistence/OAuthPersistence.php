<?php namespace App\Persistence;


use App\Includes\Exceptions\PersistenceException;

class OAuthPersistence extends Persistence {

    // TODO: Adapt for support more integrations: apps, access data (client, secret), etc.

    /**
     * @param $token
     * @param $expires
     * @param $refresh_token
     * @param $userId
     * @return bool
     * @throws PersistenceException
     */
    public static function insertPrinterAccess($token, $expires, $refresh_token, $userId){
        $query = "INSERT INTO oauth_access(token, token_expires, refresh_token, fk_user) 
                  VALUES ('$token', $expires , '$refresh_token' , $userId )";
        return self::makeQuery($query);
    }


    /**
     * @param $accessId
     * @param $status
     * @return bool
     * @throws PersistenceException
     */
    public static function updateAccessStatus($accessId, $status){
        // TODO: extends for use specific id of integration app
        $query = "UPDATE oauth_access
                    SET status = '$status'
                    WHERE fk_user = $accessId";
        return self::makeQuery($query);
    }


    /**
     * @param $token
     * @param $expires
     * @param $refresh_token
     * @param $userId
     * @return bool
     * @throws PersistenceException
     */
    public static function updatePrinterAccess($token, $expires, $refresh_token, $userId){
        $query = "UPDATE oauth_access
                    SET token = '$token', token_expires = $expires, refresh_token = '$refresh_token'
                    WHERE fk_user = '$userId'";
        return self::makeQuery($query);
    }


    /**
     * @param $token
     * @param $expires
     * @param $userId
     * @return bool
     * @throws PersistenceException
     */
    public static function updateTokenAccess_byUser($token, $expires, $userId){
        $query = "UPDATE oauth_access
                    SET token = '$token', token_expires = '$expires'
                    WHERE fk_user = '$userId'";
        return self::makeQuery($query);
    }


    /**
     * @param $printerId
     * @param $userId
     * @return bool
     * @throws PersistenceException
     */
    public static function setPrinter($printerId, $userId){
        $query = "UPDATE oauth_access
                    SET printer_id = '$printerId'
                    WHERE fk_user = '$userId'";
        return self::makeQuery($query);
    }

    /**
     * @param $userId
     * @return array
     * @throws PersistenceException
     */
    public static function getPrintAccess_byUser($userId){
        $query = "SELECT * FROM oauth_access wHERE fk_user = '$userId'";
        $src = self::makeQuery($query);
        return self::fetchFirst($src);
    }

    /**
     * @return array
     * @throws PersistenceException
     */
    public static function getAccesses(){
        $query = "SELECT * FROM oauth_access";
        $src = self::makeQuery($query);

        return self::fetchAll($src);
    }

}