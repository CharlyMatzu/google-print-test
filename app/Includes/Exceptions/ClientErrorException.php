<?php namespace App\Includes\Exceptions;


use \Exception;

/**
 * Class ClientErrorException
 * designated for error codes 400
 *
 * @package App\Includes\Exceptions
 */
class ClientErrorException extends RequestException
{
    public function __construct($statusCode, $message){
        parent::__construct($statusCode, $message);
    }
}