<?php namespace App\Includes\Google\Request;

use App\Includes\Classes\Responses;
use App\Includes\Exceptions\CurlErrorException;
use App\Includes\Exceptions\RefreshRequiredException;
use App\Includes\Exceptions\RequestException;
use Curl\Curl;

class GoogleCloudPrint{
    const HOST      = 'https://www.google.com/cloudprint';
    const SUBMIT    = '/submit';
    const SEARCH    = '/search';
    const JOBS      = '/jobs';
    const PRINTER  = '/printer';



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
     * @throws CurlErrorException
     * @throws RefreshRequiredException
     */
//    public static function getJobs($token){
//        try {
//            // Get cURL resource
//            $curl = new Curl();
//            // set
//            $curl->setHeader('Authorization', "Bearer $token");
//            $curl->setUserAgent( 'Emphasys' );
//            $curl->get('https://www.google.com/cloudprint');
//
//            if( $curl->error ) {
//                if ( $curl->errorCode === Responses::FORBIDDEN )
//                    throw new RefreshRequiredException("Expired Token");
//                else
//                    throw new CurlErrorException("Request Error: " . $curl->errorCode . ' - ' . $curl->errorMessage);
//            }
//
//
//            $response = $curl->response;
//            $curl->close();
//            return $response;
//
//        } catch (\ErrorException $e) {
//            throw new CurlErrorException( $e->getMessage() );
//        }
//
//    }

    /**
     * @param $token
     * @return object
     * @throws CurlErrorException
     * @throws RefreshRequiredException
     */
    public static function getJobs( $token ){
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL             => self::HOST . self::JOBS,
            CURLOPT_USERAGENT       => 'Emphasys',
            CURLOPT_FAILONERROR     => true,
            CURLOPT_HTTPHEADER      => [
                "Authorization: Bearer $token"
            ]
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
        if ( !$resp ){
            if( $httpCode === Responses::FORBIDDEN )
                throw new RefreshRequiredException("getJobs");

            throw new CurlErrorException( curl_error($curl) );
        }


        curl_close( $curl );
        // parse
        return json_decode($resp, true);
    }


    /**
     * @param $token
     * @return object
     * @throws CurlErrorException
     * @throws RefreshRequiredException
     */
    public static function getPrinters($token)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL             => self::HOST . self::SEARCH,
            CURLOPT_USERAGENT       => 'Emphasys',
            CURLOPT_FAILONERROR     => true,
            CURLOPT_HTTPHEADER      => [
                "Authorization: Bearer $token"
            ]
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
        if ( !$resp ){
            if( $httpCode === Responses::FORBIDDEN )
                throw new RefreshRequiredException("getPrinters");

            throw new CurlErrorException( curl_error($curl) );
        }


        curl_close( $curl );
        // parse
        return json_decode($resp, true);
    }

}