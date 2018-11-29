<?php
/**
 * Created by PhpStorm.
 * User: Carlos R. Zuñiga
 * Date: 27/08/2018
 * Time: 09:28 AM
 */


//--------------
// CUSTOM
//--------------
$container['AuthMiddleware'] = function($c){
    return new App\Middlewares\AuthMiddleware();
};