<?php namespace App\Controller;

use App\Includes\Classes\Responses;
use App\Includes\Exceptions\ClientErrorException;
use App\Service\PrintService;
use App\Service\UserService;
use Slim\Http\Request;
use Slim\Http\Response;

class APIController
{

    private $userServ;
    private $printServ;

    function __construct() {
        $this->userServ = new UserService();
        $this->printServ = new PrintService();
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
            $result = $this->userServ->signIn( $params['user'], $params['pass'] );

            return $response
                ->withStatus( Responses::OK );

        }catch (ClientErrorException $ex){
            return $response
                ->withStatus( $ex->getStatusCode() )
                ->write( $ex->getMessage()  );
        }
    }


    /**
     * @param $request Request
     * @param $response Response
     * @return Response
     * @throws \App\Includes\Exceptions\CurlErrorException
     * @throws \App\Includes\Exceptions\PersistenceException
     * @throws \App\Includes\Exceptions\RefreshRequiredException
     * @throws \App\Includes\Exceptions\ServerErrorException
     */
    public function print_submit($request, $response){
        try{
            // TODO: validate param
            $params = $request->getParsedBody();
            $this->printServ->sendToPrint( $params['document'] );

            return Responses::makeMessageResponse($response, Responses::OK, "Document sent");

        }catch (ClientErrorException $ex){
            return $response
                ->withStatus( $ex->getStatusCode() )
                ->withJson( $ex->getMessage()  );
        }
    }


    /**
     * @param       $request Request
     * @param       $response Response
     * @return Response
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function print_setDefault($request, $response){
        try{
            $params = $request->getParsedBody();
            // TODO: validate param
            $this->printServ->setPrinter( $params['printerId'] );
            return Responses::makeMessageResponse($response, Responses::OK, "Set Printer");

        }catch (ClientErrorException $ex){
            return $response
                ->withStatus( $ex->getStatusCode() )
                ->withJson( $ex->getMessage()  );
        }
    }


    /**
     * @param       $request Request
     * @param       $response Response
     * @param array $params
     * @return Response
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function print_removeDefault($request, $response, $params = []){
        try{
            $this->printServ->setPrinter( $params['printer_id'] );
            return Responses::makeMessageResponse($response, Responses::OK, "Set Printer");

        }catch (ClientErrorException $ex){
            return $response
                ->withStatus( $ex->getStatusCode() )
                ->withJson( $ex->getMessage()  );
        }
    }


}