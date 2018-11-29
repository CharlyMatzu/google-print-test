<?php
/**
 * Created by PhpStorm.
 * User: Emcor
 * Date: 28/11/2018
 * Time: 04:18 PM
 */

namespace App\controller;


use App\Includes\Classes\CookieHandler;
use App\Includes\Classes\Responses;
use App\Includes\Exceptions\ClientErrorException;
use App\Includes\Google\GooglePrint;
use App\Includes\Google\Request\GoogleAuth;
use App\Persistence\OAuthPersistence;
use App\Service\PrintService;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController
{


    /**
     * @param $request Request
     * @param $response Response
     * @param $params array
     * @return Response
     * @throws \App\Includes\Exceptions\CurlErrorException
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function authCallback($request, $response, $params = []){
        try{
            // https://oauth2.example.com/auth?error=access_denied
            // https://oauth2.example.com/auth?code=4/P7q7W...Trgtp7

            // getting params (not specified on router)
            $params = $request->getParams();

            // redirect to google auth
            if( empty($params) || isset($params['error']) )
                return $response
                    ->withRedirect(SERVER_URI . '/dashboard/google');

            // get code request
            $serv = new PrintService();
            $result = $serv->authorize($params['code'], 1);

            // redirect to google auth
            return $response
                ->withRedirect(SERVER_URI . '/dashboard/google', Responses::TEMPORARY_REDIRECT);

        }catch (ClientErrorException $ex){
            return $response
                ->withStatus( $ex->getStatusCode() )
                ->withJson( $ex->getMessage()  );
        }
    }


    /**
     * @param $request Request
     * @param $response Response
     * @param $params array
     * @return Response
     */
    public function googleAuth($request, $response, $params = []){
        $url = GoogleAuth::getAuthUrl([GooglePrint::SCOPE]);
        return $response->withRedirect($url, Responses::TEMPORARY_REDIRECT);
    }


    /**
     * @param $request Request
     * @param $response Response
     * @param $params array
     * @return Response
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function googleLogout($request, $response, $params = []){
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );

        // Update STATUS
        OAuthPersistence::updateAccessStatus( $userId, GoogleAuth::STATUS_OFF );
        // Redirect
        return $response->withRedirect(SERVER_URI . '/dashboard/google', Responses::TEMPORARY_REDIRECT);
    }


}