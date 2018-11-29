<?php namespace App\Service;

use App\Includes\Classes\CookieHandler;
use App\Includes\Classes\Responses;
use App\Includes\Exceptions\ClientErrorException;
use App\Includes\Exceptions\RequestException;
use App\Includes\Google\Request\GoogleAuth;
use App\Includes\Google\Request\GoogleCloudPrint;
use App\Persistence\OAuthPersistence;

class PrintService{

    public function __construct() {}


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
            $result = OAuthPersistence::updatePrinterAccess( $auth->access_token, $auth->expires_in, $auth->token_type, $userId );
        else
            $result = OAuthPersistence::insertPrinterAccess( $auth->access_token, $auth->expires_in, $auth->token_type, $userId );

        // update status
        $result = OAuthPersistence::updateAccessStatus($userId, GoogleAuth::STATUS_ON);
        return true;
    }


    /**
     * @param $userId
     * @return mixed
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function getGooglePrintAccess_byUser($userId){

        // TODO: validate user
//        $userId = UserPersistence::getUser_byId( $userId );
//        if( empty($userId) )
//            throw new ClientErrorException(  )

        $access = OAuthPersistence::getPrintAccess_byUser($userId);
        return $access;
    }

    /**
     * @throws RequestException
     */
    public function logoutGoogle() {
        try {
            // TODO: validate user
            $userId = CookieHandler::getCookieData();
            // change status access as OFF
            return OAuthPersistence::updateAccessStatus($userId, GoogleAuth::STATUS_OFF);

        } catch (\Exception $e) {
            throw new RequestException(Responses::INTERNAL_SERVER_ERROR, $e->getMessage());
        }

    }


    //----------------------------------------
    // GOOGLE CLOUD PRINT
    //----------------------------------------

    /**
     * @throws \Exception
     */
    public function getPrinterJobs(){

        // TODO: handle empty
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );
        if( !empty($access) )
            return $access;

        // TODO: handle access correctly

//        if( empty($access) )
//            throw new RequestException(Responses::NO_CONTENT, "");
//        else if( $access[0]['status'] === OAuthPersistence::STATUS_OFF ){
//            throw new RequestException(Responses::NO_CONTENT, "");
//        }
//        else{
//
//        }

        $result = GoogleCloudPrint::getJobs( $access['token'] );

        return $result;
    }


    public function sendToPrint($document){

    }


}