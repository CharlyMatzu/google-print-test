<?php namespace App\Includes\Exceptions;


use App\Includes\Classes\Responses;
use \Exception;

/**
 * Class ClientErrorException
 * designated for error codes 500
 *
 * @package App\Includes\Exceptions
 */
class ServerErrorException extends RequestException
{
    public function __construct($message){
        parent::__construct(Responses::INTERNAL_SERVER_ERROR, $message);
    }
}