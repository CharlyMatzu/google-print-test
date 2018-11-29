<?php namespace App\Service;

use App\Includes\Classes\CookieHandler;
use App\Includes\Exceptions\CurlErrorException;
use App\Includes\Exceptions\RefreshRequiredException;
use App\Includes\Google\Request\GoogleAuth;
use App\Includes\Google\Request\GoogleCloudPrint;
use App\Persistence\OAuthPersistence;

class PrintService{

    public function __construct() {}



    /**
     * @param $userId
     * @return mixed
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function getGooglePrintAccess_byUser($userId)
    {
        // TODO: validate user
//        $userId = UserPersistence::getUser_byId( $userId );
//        if( empty($userId) )
//            throw new ClientErrorException(  )

        $access = OAuthPersistence::getPrintAccess_byUser($userId);
        return $access;
    }


    /**
     * Request a refresh token and update oauth access
     * @throws \App\Includes\Exceptions\PersistenceException
     * @throws CurlErrorException
     */
    public function refreshToken()
    {
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );
        // TODO: validate status
        $data = GoogleAuth::refreshToken( $access['refresh_token'] );
        OAuthPersistence::updateTokenAccess_byUser( $data->access_token, $data->expires_in, $userId );
        return $data;
    }


    //----------------------------------------
    // GOOGLE CLOUD PRINT
    //----------------------------------------
    /**
     * @return object
     * @throws \App\Includes\Exceptions\PersistenceException
     * @throws CurlErrorException
     * @throws RefreshRequiredException
     */
    public function getPrintJobs()
    {
        // Get credentials
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );
        // Request
        $jobs = array();
        try {
            $jobs = GoogleCloudPrint::getJobs( $access['token'] );
        } catch (RefreshRequiredException $e) {
            // If refresh is required, request refresh token
            // TODO: make callable for multi usage  (use callbacks)
            $access = $this->refreshToken();
            // try again
            $jobs = GoogleCloudPrint::getJobs( $access['token'] );
        }

        // TODO: handle 'success: false'
        return $jobs;
    }

    /**
     * @return array|object
     * @throws CurlErrorException
     * @throws RefreshRequiredException
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function getPrinters()
    {
        // Get credentials
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );
        // Request
        $printers = array();
        try {
            $printers = GoogleCloudPrint::getPrinters( $access['token'] );
        } catch (RefreshRequiredException $e) {
            // If refresh is required, request refresh token
            // TODO: make callable for multi usage  (use callbacks)
            $access = $this->refreshToken();
            // try again
            $printers = GoogleCloudPrint::getPrinters( $access['token'] );
        }

        // TODO: handle 'success: false'
        return $printers;
    }


    public function sendToPrint($document){

    }




}