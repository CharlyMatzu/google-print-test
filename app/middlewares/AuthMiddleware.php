<?php namespace App\Middlewares;
use App\Includes\Classes\CookieHandler;
use App\Includes\Classes\Responses;
use App\Includes\Google\GooglePrint;
use App\Includes\Google\Request\GoogleAuth;
use App\Persistence\OAuthPersistence;
use App\Persistence\UserPersistence;
use App\Service\PrintService;
use Slim\Http\Request;
use Slim\Http\Response;


/**
 * Created by PhpStorm.
 * User: Carlos R. Zuñiga
 * Date: 27/08/2018
 * Time: 09:28 AM
 */

class AuthMiddleware
{
    function __construct() {}


    /**
     * @param $request Request
     * @param $response Response
     * @param $next callable (next middleware or controller to call)
     * @return Response
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function midd_validateLogout($request, $response, $next){
        $userId = CookieHandler::getCookieData();
        // validate user
        if( $userId ) {
            $user = UserPersistence::getUser_byId($userId);
            if ($user)
                return $response->withRedirect(SERVER_URI . '/dashboard');
        }
        // Call next callable method
        $res = $next($request, $response);
        return $res;
    }

    /**
     * @param $request Request
     * @param $response Response
     * @param $next callable (next middleware or controller to call)
     * @return Response
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function midd_validateLogin($request, $response, $next){
        $userId = CookieHandler::getCookieData();
        if( $userId ) {
            $user = UserPersistence::getUser_byId($userId);
            if (!$user)
                return $response->withRedirect(SERVER_URI . '/login');
        }

        // Call next callable method
        $res = $next($request, $response);
        return $res;
    }

    /**
     * @param $request Request
     * @param $response Response
     * @param $next callable (next middleware or controller to call)
     * @return Response
     */
    public function midd_googleAuth($request, $response, $next){
        $params = $request->getParams();

        if( empty($params['status']) )
            return $response->withRedirect( SERVER_URI . '/dashboard/jobs' );

        //check state param for handle possible CRSF attack
        if( !$params['status'] || $params['status'] !== STATE )
            return Responses::makeMessageResponse( $response, Responses::BAD_REQUEST, "Invalid state param" );

        // Call next callable method
        $res = $next($request, $response);
        return $res;
    }


    /**
     * @param $request Request
     * @param $response Response
     * @param $next callable (next middleware or controller to call)
     * @return Response
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function midd_isGoogleAuthenticated($request, $response, $next){
        // get userId session
        $userId = CookieHandler::getCookieData();
        // get token access
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );

        // Validate access
        if( empty($access) || ($access['status'] === GoogleAuth::STATUS_OFF ) )
            return $response->withRedirect( SERVER_URI . '/dashboard/google' );

        // Call next callable method
        $res = $next($request, $response);
        return $res;
    }


}