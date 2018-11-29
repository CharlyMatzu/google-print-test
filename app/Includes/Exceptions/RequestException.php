<?php namespace App\Includes\Exceptions;
/**
 * Created by PhpStorm.
 * User: Carlos R. Zuñiga
 * Date: 27/08/2018
 * Time: 01:59 PM
 */

use \Exception;

class RequestException extends Exception
{
    protected $statusCode;

    /**
     * RequestException constructor.
     * @param $statusCode int HTTP code response
     * @param $message String Exception Message
     */
    public function __construct($statusCode, $message)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


}