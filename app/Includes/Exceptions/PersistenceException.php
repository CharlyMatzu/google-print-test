<?php namespace App\Includes\Exceptions;
use App\Includes\Classes;

class PersistenceException extends \Exception
{
    /**
     * PersistenceException constructor.
     * @param $message String
     */
    public function __construct($message)
    {
        parent::__construct( $message );
    }
}