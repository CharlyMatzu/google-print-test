<?php namespace App\Persistence;

use App\Includes\Database\MySQLConnection;
use App\Includes\Exceptions\PersistenceException;

class Persistence
{
    /**
     * @param $query
     * @return bool|mysqli_result
     * @throws PersistenceException
     */
    protected static function makeQuery($query){
        try{
            MySQLConnection::connect();
            $result = MySQLConnection::doQuery( $query );
            if( !$result )
                throw new PersistenceException("Query execution error: " . MySQLConnection::getError());

            // Close and return
            MySQLConnection::closeConnection();
            return $result;

        }catch (\Exception $ex){
            throw new PersistenceException( $ex->getMessage() );
        }

    }

    /**
     * @param $resource mysqli_result
     * @return array
     */
    protected static function fetchAll( $resource ){
        $data = array();
        while ($row = mysqli_fetch_assoc( $resource ) )
            $data[] = $row;
        return $data;
    }

    /**
     * @param $resource
     * @return array|null
     */
    protected static function fetchFirst( $resource ){
        $data = mysqli_fetch_assoc( $resource );
        return $data;
    }

}