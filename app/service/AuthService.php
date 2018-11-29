<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 29/11/2018
 * Time: 02:34 AM
 */

namespace App\service;


use App\Includes\Classes\Responses;
use App\Includes\Exceptions\ClientErrorException;
use App\Includes\Google\Request\GoogleAuth;
use App\Persistence\OAuthPersistence;

class AuthService
{

    /**
     * request token using authorization code
     *
     * @param $code String authorization code
     * @param $userId int User id
     * @return array|bool|mixed|
     * @throws ClientErrorException
     * @throws \App\Includes\Exceptions\CurlErrorException
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function authorize($code, $userId){
        //User exists validation
        $userServ = new UserService();
        if( !$userServ->isUserExist( $userId ) )
            throw new ClientErrorException( Responses::NOT_FOUND, "User does not exist");

        // Get Token
        $auth = GoogleAuth::authorizeRequest($code);

        //---------- Token register
        // Get Google access
        $user = OAuthPersistence::getPrintAccess_byUser($userId);

        // if user is already registered data will update
        if( !empty($user) )
            $result = OAuthPersistence::updatePrinterAccess( $auth->access_token, $auth->expires_in, $auth->refresh_token, $userId );
        else
            $result = OAuthPersistence::insertPrinterAccess( $auth->access_token, $auth->expires_in, $auth->refresh_token, $userId );

        // update status
        $result = OAuthPersistence::updateAccessStatus($userId, GoogleAuth::STATUS_ON);
        return true;
    }

}