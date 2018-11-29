<?php
/**
 * Created by PhpStorm.
 * User: Carlos R. Zuñiga
 * Date: 20/08/2018
 * Time: 04:02 PM
 */

// Error config
error_reporting( E_ERROR | E_PARSE );
// PHP interpreter runtime config
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

session_start();

// ---------ROUTES
//define("ROOT_HOST", '/iprinter-slim');
define("ROOT_HOST", '');

// --------- PATHS
//define("DS",            DIRECTORY_SEPARATOR); // using with absolute path
define('ROOT_PATH',     __DIR__ ); // For absolute path
define("VENDOR_PATH",   ROOT_PATH . "/vendor");
define("APP_PATH",      ROOT_PATH . "/app");
define("INCLUDES_PATH", APP_PATH  . "/Includes");

// Keep in mind the log location. Apache (server) will be the owner and only root or directory owner (of logs) will be able
// to manage those file
define("LOG_PATH",      ROOT_PATH . "/logs");
define("LOG_ACTIVITY",  LOG_PATH  . "/activity");
define("LOG_DEBUG",     LOG_PATH  . "/debug");
define("LOG_ERROR",     LOG_PATH  . "/error");

define('PROTOCOL',      'https://');
define('SERVER_URI',    PROTOCOL . $_SERVER['HTTP_HOST'] . ROOT_HOST);

// ---------------- GOOGLE OAUTH AND GOOGLE CLOUD PRINT

// https://developers.google.com/identity/protocols/OAuth2ServiceAccount

define('CLIENT_ID',         '588989867940-aqukg3gs6r8nft9etqc857e5jpad91ao.apps.googleusercontent.com');
define('CLIENT_SECRET',     'Ulc0zm0gw9B0EeKfAU0cgUWX');
//define('REDIRECT_URI',    'https://88710f63.ngrok.io' . ROOT_HOST . '/callback.php');
define('REDIRECT_URI',      SERVER_URI . '/auth/callback' );
define('STATE',             'TEST');
define('USER_AGENT',        "Local machine");


//---------------- DATABASE

const DBConfig = [
    'host'      => 'localhost',
    'user'      => 'root',
    'pass'      => '',
    'database'  => 'iprinter_db'
];
