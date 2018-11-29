<?php namespace App\Includes\Google\Request;

use App\Includes\Classes\Responses;
use App\Includes\Exceptions\RequestException;
use Curl\Curl;

class GoogleCloudPrint{
    const HOST      = 'https://www.google.com/cloudprint';
    const SUBMIT    = '/submit';
    const SEARCH    = '/search';
    const JOBS      = '/jobs';
    const PRINTERS  = '/printer';



    /**
     * @param $token
     * @param $printerId
     * @param $title
     * @param $documentURl
     * @param $type
     * @return object
     * @throws \ErrorException
     * @throws \Exception
     */
//    public static function sendToPrint($token, $printerId, $title, $documentURl, $type){
//        // Get cURL resource
//        $curl = new Curl();
//        $curl->setHeaders(['Authorization' => "Bearer $token"]);
//        $curl->post(self::HOST . self::SUBMIT,  array(
//            'printerid'     => $printerId,
//            'title'         => $title,
//            'ticket'        => '{"version": "1.0", "print" {}}',
//            'contentType'   => $type,
//            'content'       => $documentURl
//        ));
//
//        // TODO: handle error codes
//        if ( $curl->error )
//            throw new RequestException($curl->errorCode, "Request Error: " . $curl->errorCode . ' - ' . $curl->errorMessage);
//
//        $response = $curl->response;
//        $curl->close();
//        return $response;
//    }

    /**
     * @param $token String
     * @return object
     * @throws \ErrorException
     * @throws \Exception
     */
//    public static function getPrinters($token){
//        // Get cURL resource
//        $curl = new Curl();
//        $curl->setHeaders(['Authorization' => "Bearer $token"]);
//        $curl->get(self::HOST . self::PRINTERS );
//
//        // TODO: handle error codes
//        if ( $curl->error )
//            throw new RequestException($curl->errorCode, "Request Error: " . $curl->errorCode . ' - ' . $curl->errorMessage);
//
//        $response = $curl->response;
//        $curl->close();
//        return $response;
//    }


    /**
     * @param $token String
     * @return object
     * @throws RequestException
     * @throws \ErrorException
     */
    public static function getJobs($token){
        // Get cURL resource
        $curl = new Curl();
        $curl->setHeader('Authorization', "Bearer $token");
        $curl->get('https://www.google.com/cloudprint');

        // TODO: handle error codes
        if( $curl->error ) {
            // TODO: when is 403 error code, trigger refresh token request
            if ($curl->errorCode === Responses::FORBIDDEN){

            }
            else
                throw new RequestException($curl->errorCode, "Request Error: " . $curl->errorCode . ' - ' . $curl->errorMessage);
        }


        $response = $curl->response;
        $curl->close();
        return $response;
    }


    public static function deleteJob($token, $jobId){

    }

    public static function getPrinterInfo($token, $printerId){

    }

}