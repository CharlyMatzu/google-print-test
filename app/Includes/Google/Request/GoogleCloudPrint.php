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
     * @throws CurlErrorException
     * @throws RefreshRequiredException
     */
    public static function sendToPrint($token, $printerId, $title, $documentURl, $type){
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL             => self::HOST . self::SUBMIT,
            CURLOPT_USERAGENT       => 'Emphasys',
            CURLOPT_FAILONERROR     => true,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => [
                'printerid'     => $printerId,
                'title'         => $title,
                'ticket'        => '{
                                      "version": "1.0",
                                      "print": {
                                        "vendor_ticket_item": [],
                                        "color": {"type": "STANDARD_MONOCHROME"},
                                        "copies": {"copies": 1}
                                      }
                                    }',
                'contentType'   => $type,
                'content'       => $documentURl
            ],
            CURLOPT_HTTPHEADER      => [
                "Authorization: Bearer $token"
            ]
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
        if ( !$resp ){
            if( $httpCode === Responses::FORBIDDEN )
                throw new RefreshRequiredException("submit");

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