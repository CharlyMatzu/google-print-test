<?php


$container['AuthController'] = function($c){
    return new App\Controller\AuthController();
};

$container['APIController'] = function($c){
    return new App\Controller\APIController();
};