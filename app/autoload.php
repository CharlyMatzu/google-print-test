<?php

// OPTIONAL CUSTOM AUTOLOADER
spl_autoload_register("autoloader");

function autoloader($class_name){
    $class_name = "$class_name.php";

    //if class does not exist. Throw Exception
    if( !file_exists($class_name) )
        throw new \Exception("Error to load class: ". $class_name);

    include_once( $class_name );
}
