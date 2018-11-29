<?php namespace App\Includes\Classes;
/**
 * Created by PhpStorm.
 * User: Carlos R. Zuñiga
 * Date: 27/11/2018
 * Time: 10:19 AM
 */


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class FlatLogger
 * Use for simple log creation
 * @see https://github.com/Seldaek/monolog
 * @see https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md
 * @see https://stackify.com/php-monolog-tutorial/
 *
 * @package App\Includes
 */
class FlatLogger
{

    /*
        As illustrated in RFC 5424 which describes the syslog protocol, the following levels of intensity are applied in Monolog.

        DEBUG:      Detailed debugging information.
        INFO:       Handles normal events. Example: SQL logs
        NOTICE:     Handles normal events, but with more important events
        WARNING:    Warning status, where you should take an action before it will become an error.
        ERROR:      Error status, where something is wrong and needs your immediate action
        CRITICAL:   Critical status. Example: System component is not available
        ALERT:      Immediate action should be exercised. This should trigger some alerts and wake you up during night time.
        EMERGENCY:  It is used when the system is unusable.

    */

    /**
     * Create a logger depending of the type
     * NOTE: Require write permission
     * @param $logTitle String Title to identify log line
     * @param $path String path of the log
     * @param $type int level type, @see Logger::INFO
     * @param $message String log description
     * @param $extra array Extra information
     */
    private static function makeLog($logTitle, $path, $type, $message, $extra ){

        // file name using current date
        $log_name = date("Y-m-d" );
        $file = $path . "/" . $log_name . ".log";

        //check if is empty
        if( empty($extra) )
            $extra = [];
        //if is an object cast to array
        if( !is_array($extra) ){
            $extra = ["extra" => (String)$extra];
        }

        try {
            $log = new Logger( $logTitle );
            $log->pushHandler(new StreamHandler($file, $type));

            switch ( $type ){
                case Logger::INFO: $log->addInfo( $message, $extra ); break;
                case Logger::ERROR: $log->addError( $message, $extra ); break;
                case Logger::DEBUG: $log->addDebug( $message, $extra ); break;

                default: $log->addInfo( $message, $extra );
            }

        } catch (\Exception $e) {
            // TODO: Use alternative logger using function file_put_contents()
//            file_put_contents( $file, "probando\r\n", FILE_APPEND );
        }
    }

    //TODO: add log title for custom cases
    /**
     * Use for Critical Error Logging
     * @param $message String log description
     * @param $extra array Extra information
     */
    public static function makeErrorLog($message, $extra = []){
        self::makeLog( "Error-Logging", LOG_ERROR, Logger::ERROR, $message, $extra );
    }

    /**
     * Use for Information logging like SQL log or activities
     * @param $message String log description
     * @param $extra array Extra information
     */
    public static function makeInfoLog($message, $extra = []){
        self::makeLog( "Info-Logging", LOG_ACTIVITY, Logger::INFO, $message, $extra );
    }


    /**
     * Use for Debugging
     * @param $message String log description
     * @param $extra array Extra information
     */
    public static function makeDebugLog($message, $extra = []){
        self::makeLog( "Debug-Logging", LOG_DEBUG, Logger::DEBUG, $message, $extra );
    }

}