<?php


require_once "config.php";

//Autoloader for vendor and own classes
require_once "vendor/autoload.php";

//session_start();

// TODO: use relative paths

// Instantiate the app
$settings = require_once ROOT_PATH . '/app/Includes/settings.php';
$app = new \Slim\App( $settings );

$container = $app->getContainer();

// Set up dependencies
require_once ROOT_PATH . '/app/Includes/dependencies.php';

// Register middleware
require_once ROOT_PATH . '/app/Includes/middleware.php';

// Render support
require_once ROOT_PATH . '/app/Includes/render.php';

// Error Handler
require_once ROOT_PATH . '/app/Includes/errorHandler.php';

// Register routes
require_once ROOT_PATH . '/app/Includes/router.php';


try {
    // Run app
    $app->run();
} catch (\Slim\Exception\MethodNotAllowedException $e) {
    echo "Error: ".$e->getMessage();
} catch (\Slim\Exception\NotFoundException $e) {
    echo "Error: ".$e->getMessage();
} catch (Exception $e) {
    echo "Error: ".$e->getMessage();
}