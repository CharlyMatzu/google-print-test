<?php
/**
 * Created by PhpStorm.
 * User: Emcor
 * Date: 28/11/2018
 * Time: 09:43 AM
 */

namespace App\controller;

use App\Includes\Classes\Responses;
use App\Includes\Exceptions\RequestException;
use App\Service\PrintService;
use Slim\Http\Request;
use Slim\Http\Response;

class PrintController
{

    /**
     * @param $request Request
     * @param $response Response
     * @param $params array
     * @return Response
     */
    public function getPrinters($request, $response, $params = []){

        try{
            $serv = new PrintService();
            $result = $serv->getPrinters();
            if( !empty($result) )
                return $response->withStatus( Responses::OK )->withStatus( $result );
            else
                return $response->withStatus( Responses::NO_CONTENT )->withStatus( $result );

        }catch (RequestException $ex){
            return $response
                ->withStatus( $ex->getStatusCode() )
                ->withJson( $ex->getMessage()  );
        }
    }

}