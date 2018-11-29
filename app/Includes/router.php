<?php
/**
 * Created by PhpStorm.
 * User: Carlos R. Zuñiga
 * Date: 27/11/2018
 * Time: 09:19 AM
 */

use Slim\Http\Request;
use Slim\Http\Response;



//---------------------------------------------
//  VIEWS ROUTES
//---------------------------------------------

// main redirection
$app->get('/', function (Request $req,  Response $res, $params = []) {
    return $res->withRedirect( SERVER_URI . "/login" );
});



//------ LOGIN SECTION

$app->get('/login', function (Request $req,  Response $res, $params = []){
    $controller = new \App\controller\ViewsController($req, $res, $params, $this->view);
    return $controller->renderLogin();
})
    ->setName('form-login')
    ->add('AuthMiddleware:midd_validateLogout');


$app->get('/register', function (Request $req,  Response $res, $params = []){
    $controller = new \App\controller\ViewsController($req, $res, $params, $this->view);
    return $controller->renderRegister();
})
    ->setName('form-register')
    ->add('AuthMiddleware:midd_validateLogout');







//------ DASHBOARD SECTION

$app->group('/dashboard', function () {


    $this->get('/jobs[/]', function (Request $req,  Response $res, $params = []){
        $controller = new \App\controller\ViewsController($req, $res, $params, $this->view);
        return $controller->renderDashboard_jobs();
    })
        ->setName('dashboard-print-jobs')
        ->add('AuthMiddleware:midd_isGoogleAuthenticated');


    $this->get('/printers[/]', function (Request $req,  Response $res, $params = []){
        $controller = new \App\controller\ViewsController($req, $res, $params, $this->view);
        return $controller->renderDashboard_printers();
    })
        ->setName('dashboard-printers')
        ->add('AuthMiddleware:midd_isGoogleAuthenticated');


    $this->get('/tutorial[/]', function (Request $req,  Response $res, $params = []){
        $controller = new \App\controller\ViewsController($req, $res, $params, $this->view);
        return $controller->renderDashboard_tutorial();
    })->setName('dashboard-tutorial');


    $this->get('/google[/]', function (Request $req,  Response $res, $params = []){
        $controller = new \App\controller\ViewsController($req, $res, $params, $this->view);
        return $controller->renderDashboard_google();
    })->setName('dashboard-google');



    $this->get('/logout[/]', function (Request $req,  Response $res, $params = []){
        $controller = new \App\controller\ViewsController($req, $res, $params);
        return $controller->logout();
    })->setName('dashboard-logout');


})->add('AuthMiddleware:midd_validateLogin');



//---------------------------------------------
//  API ROUTES
//---------------------------------------------
$app->group('/api', function () {

    //------- Login
    $this->post('/login[/]', 'APIController:login');

    //-------- Google cloud print
    $this->post('/print/submit[/]', 'APIController:print_submit');

    $this->post('/print/set', 'APIController:print_setDefault');

//    $this->post('/print/printer/remove', 'APIController:print_removeDefault');

});

//---------------------------------------------
//  AUTH ROUTES
//---------------------------------------------


$app->group('/auth', function () {

    $this->get('/google[/]', 'AuthController:googleAuth')
        ->setName('google-auth');

    // TODO: validate params
    $this->get('/callback[/]', 'AuthController:authCallback')
        ->setName('google-auth-redirect');
//        ->addMiddleware('');

    $this->get('/logout[/]', 'AuthController:googleLogout')
        ->setName('google-logout');

});