<?php
/**
 * Created by PhpStorm.
 * User: Emcor
 * Date: 28/11/2018
 * Time: 03:07 PM
 */

namespace App\controller;


use App\Includes\Classes\CookieHandler;
use App\Includes\Google\Request\GoogleAuth;
use App\Persistence\OAuthPersistence;
use App\service\AuthService;
use App\Service\PrintService;
use Slim\Http\Request;
use Slim\Http\Response;

class ViewsController
{
    private $service;
    private $request;
    private $response;
    private $params;
    private $view;

    /**
     * @param $request Request
     * @param $response Response
     * @param $params array
     * @param $view \Slim\Views\Twig
     */
    public function __construct($request, $response, $params, $view = null){
        $this->request = $request;
        $this->response = $response;
        $this->params = $params;
        $this->view = $view;

//        $this->service = new Views
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function renderLogin()
    {
        return $this->view
            ->render($this->response, 'login.twig', [
                'HOST' => SERVER_URI,
                'TITLE' => 'Login',
            ]);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function renderRegister()
    {
        return $this->view
            ->render($this->response, 'register.twig', [
                'HOST' => SERVER_URI,
                'TITLE' => 'Register',
            ]);
    }


    //---------------------------- DASHBOARD


    /**
     * Render jobs page
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \App\Includes\Exceptions\CurlErrorException
     * @throws \App\Includes\Exceptions\PersistenceException
     * @throws \App\Includes\Exceptions\RefreshRequiredException
     */
    public function renderDashboard_jobs()
    {
        $serv = new PrintService();
        $jobs = $serv->getPrintJobs();

        // Current selected printer
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );
        $printer = array();
        if( !empty($access['printer_id']) ) {
            // Get Full Printer info
            $printer = $serv->getPrinter($access['printer_id']);
        }

        return $this->view
            ->render($this->response, 'jobs.twig', [
                'HOST'      => SERVER_URI,
                'TITLE'     => 'Printer Jobs',
                'PAGE'      => 'jobs',
                'JOBS'      => $jobs['jobs'],
                'PRINTER'   => $printer
            ]);
    }

    /**
     * Render printers page
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \App\Includes\Exceptions\CurlErrorException
     * @throws \App\Includes\Exceptions\PersistenceException
     * @throws \App\Includes\Exceptions\RefreshRequiredException
     */
    public function renderDashboard_printers()
    {
        // Printers
        $serv = new PrintService();
        $printers = $serv->getPrinters();
        // Current selected printer
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );
        $default = $access['printer_id'];

        return $this->view
            ->render($this->response, 'printers.twig', [
                'HOST'      => SERVER_URI,
                'TITLE'     => 'Printers',
                'PAGE'      => 'printers',
                'PRINTERS'  => $printers['printers'],
                'DEFAULT'   => $default
            ]);
    }


    /**
     * Render tutorial page
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function renderDashboard_tutorial()
    {
        return $this->view
            ->render($this->response, 'tutorial.twig', [
                'HOST' => SERVER_URI,
                'TITLE' => 'Tutorial',
                'PAGE' => 'tutorial'
            ]);
    }


    /**
     * Render google page
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \App\Includes\Exceptions\PersistenceException
     */
    public function renderDashboard_google()
    {
        // check authentication
        $userId = CookieHandler::getCookieData();
        $access = OAuthPersistence::getPrintAccess_byUser( $userId );
        $isAuth = true;
        if( empty($access) || ($access['status'] === GoogleAuth::STATUS_OFF) )
            $isAuth = false;

        return $this->view
            ->render($this->response, 'google.twig', [
                'HOST'   => SERVER_URI,
                'TITLE'  => 'Google Account',
                'PAGE'   => 'google',
                'isAUTH' => $isAuth
            ]);
    }


    /**
     * Remove cookie session and redirect
     * @return Response
     */
    public function logout()
    {
        CookieHandler::removeCookie();
        return $this->response->withRedirect(SERVER_URI . '/login');
    }



}