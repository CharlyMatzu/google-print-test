<?php namespace App\Service;


use App\Includes\Classes\CookieHandler;
use App\Includes\Classes\Responses;
use App\Includes\Exceptions\ClientErrorException;
use App\Includes\Exceptions\PersistenceException;
use App\Persistence\UserPersistence;

class UserService
{

    //---------------- USER SESSION

    public static function validateLoggedIn(){
        if( !isset( $_SESSION['user'] ) )
            header('Location: ' . ROOT_HOST . "/login.php");
    }

    // TODO: use cookies
    public static function setUserSession(){
        $_SESSION['user'] = "test";
    }

    public static function cleanSession(){
        unset( $_SESSION['user'] );
    }


    //---------------- PERSISTENCE

    /**
     * @param $user String
     * @param $pass String
     * @return bool
     * @throws PersistenceException
     * @throws ClientErrorException
     */
    public function signIn($user, $pass){
        $result = UserPersistence::signIn($user, $pass);
        if( empty($result) )
            throw new ClientErrorException( Responses::UNAUTHORIZED, "User or Password incorrect" );

        // save cookie session if user exists
        // TODO: add more security
        CookieHandler::makeSessionCookie( $result['user_id'] );
        return true;
    }

    public function signOut(){
        CookieHandler::removeCookie();
        return true;
    }

    /**
     * @param $userId
     * @return array
     * @throws PersistenceException
     */
    public function getUser_byId($userId){
        $result = UserPersistence::getUser_byId( $userId );
        return $result;
    }

    /**
     * @param $userId
     * @return bool TRUE if user exists, FALSE if not
     * @throws PersistenceException
     */
    public function isUserExist($userId){
        $result = $this->getUser_byId($userId);
        return !empty($result);
    }

}