<?php namespace App\Includes\Database;

use \Exception;
use mysqli;
use mysqli_result;


class MySQLConnection {

    /**
     * @var mysqli
     */
    private static $_connection;

    /**
     * Establish new Database Connection
     * MySQLConnection constructor.
     * @throws Exception
     */
    public static function connect(){
        self::$_connection = new mysqli(
            DBConfig['host'],
            DBConfig['user'],
            DBConfig['pass'],
            DBConfig['database']
        );

        // Error Handling
        if( mysqli_connect_error() ) {
            throw new Exception("Connect", "An error occurred trying to connect with MYSQL", mysqli_connect_error() );
        }
        // UTF8 encoding
        if ( !self::$_connection->set_charset('utf8') )
            throw new Exception("UTF-8","An error occurred when encoding UTF8 characters", self::getError() );
    }


    /**
     * @param $query String query to execute
     * @return bool|mysqli_result return mysqli_result when query is success
     * TRUE with success operation. FALSE when a error has ocurred
     */
    public static function doQuery($query){
        return self::$_connection->query($query);
    }
    /**
     * Retrieve last error
     * @return string Message error
     */
    public static function getError(){
        return self::$_connection->error;
    }
    /**
     * Close connection
     * @return bool FALSE with error , TRUE when success
     */
    public static function closeConnection(){
        return self::$_connection->close();
    }


}