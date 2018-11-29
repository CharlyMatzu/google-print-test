<?php namespace App\Includes\Classes;

use Slim\Http\Response;

/**
 * Created by PhpStorm.
 * User: Carlos R. Zuñiga
 * Date: 27/08/2018
 * Time: 10:49 AM
 */

class Responses
{

    //---------------------------
    // REQUEST STATUS RESPONSES
    //---------------------------
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status

    /**
     * The request has succeeded. The meaning of a success varies depending on the HTTP method:
     * GET: The resource has been fetched and is transmitted in the message body.
     * HEAD: The entity headers are in the message body.
     * PUT or POST: The resource describing the result of the action is transmitted in the message body.
     * TRACE: The message body contains the request message as received by the server
     */


    const OK = 200;

    const CREATED = 201;

    const NO_CONTENT = 204;

    const MOVED_PERMANENTLY = 301;

    const TEMPORARY_REDIRECT = 307;

    const PERMANENT_REDIRECT = 308;

    const BAD_REQUEST = 400;

    const UNAUTHORIZED = 401;

    const FORBIDDEN = 403;

    const NOT_FOUND = 404;

    const METHOD_NOT_ALLOWED = 405;

    const CONFLICT = 409;

    const LENGTH_REQUIRED = 411;

    const INTERNAL_SERVER_ERROR = 500;


    //---------------------------
    // METHODS
    //---------------------------

    /**
     * @param $response Response
     * @param $statusCode int HTTP response status code
     * @see Responses
     * @see Responses::OK
     * @param $message String message for response
     * @return Response
     */
    public static function makeMessageResponse($response, $statusCode, $message){
        return $response
            ->withStatus( $statusCode )
//            ->withHeader( 'Content-Type', 'application/json' )
            ->withJson(
                [
                    'ResponseCode' => $statusCode,
                    'Message' => $message
                ]
            );
    }

    /**
     * @param $response Response
     * @param $statusCode int HTTP response status code
     * @param $json_key String json key name to identify element
     * @param $result @mixed values
     * @return Response
     * @see Responses
     * @see Responses::OK
     */
    public static function makeResultResponse($response, $statusCode, $json_key, $result){
        return $response
            ->withStatus( $statusCode )
            ->withHeader( 'Content-Type', 'application/json' )
            ->withJson(
                [
                    'ResponseCode' => $statusCode,
                    $json_key => $result
                ]
            );
    }

    /**
     * Add Cross-origin resource sharing ( CORS ) to response
     * @param $response Response
     * @return Response
     */
    public static function setCORStoResponse($response){
//        return $response;
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }



}