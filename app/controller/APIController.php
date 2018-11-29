<?php namespace App\Controller;

use App\Includes\Classes\Responses;
use App\Includes\Exceptions\ClientErrorException;
use App\Service\UserService;
use Slim\Http\Request;
use Slim\Http\Response;

class APIController
{

    private $service;
    function __construct() {
        $this->service = new UserService();
    }


    /**
     * @param $request Request
     * @param $response Response
     * @return Response
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function login($request, $response)
    {
        try{
            //TODO: use middleware for validate params

            // get params
            $params = $request->getParsedBody();
            // Search and assign cookie
            $result = $this->service->signIn( $params['user'], $params['pass'] );

            return $response
                ->withStatus( Responses::OK );

        }catch (ClientErrorException $ex){
            return $response
                ->withStatus( $ex->getStatusCode() )
                ->withJson( $ex->getMessage()  );
        }
    }



}