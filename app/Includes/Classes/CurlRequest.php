<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 29/11/2018
 * Time: 03:18 AM
 */

namespace App\Includes\Classes;


use App\Includes\Exceptions\CurlErrorException;

class CurlRequest
{

    /**
     * @param $token
     * @return object
     * @throws CurlErrorException
     */
    public static function makeRequest( $token ){
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
        if ( !$resp )
            throw new CurlErrorException( curl_error($curl) );

        curl_close( $curl );
        // parse
        return json_decode($resp, true);
    }

}