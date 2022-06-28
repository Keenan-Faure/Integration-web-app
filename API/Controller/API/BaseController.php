<?php

namespace controller;

class Controller
{
    function __call()
    {
        $variable = new \stdClass();
        $variable->result = array();
        $variable->error = new \stdClass();
        $variable->error->errorcode = '404';
        $variable->error->errormessage = 'HTTP/1.1 404 Not Found';

        return $variable;
    }

    function endpoints($serverconnection)
    {
        /*
        {
            result: true,
            URL: 192.168.64.3/MySQL-API/API/api.php - use php server to get it...
            description: 'MySql API',
            version: 1.0.1,
            routes:
            {
                products: 
                {

                },
                customers:
                {

                },
                utility:
                {

                }
            }
        }
        */
        if($_SESSION['apicredentials']->active === true && $serverconnection === true)
        {
            $variable = new \stdClass();
            $variable->result = true;
            $variable->url = $_SERVER['REQUEST_URI'];
            $variable->description = 'MySql API';
            $variable->version = 'v1.0.1';
            $variable->routes = new \stdClass();
            $variable->routes->products = new \stdClass();
            $variable->routes->customers = new \stdClass();
            $variable->routes->utility = new \stdClass();
        }
    }

    //handles products endpoints
    function products()
    {
        if($_SESSION['apicredentials']->active === true)
        {
            
        }
    }

    //handles the customer endpoints
    function customers()
    {
        if($_SESSION['apicredentials']->active === true)
        {

        }
    }

    function utility()
    {
        if($_SESSION['apicredentials']->active === true)
        {

        }
    }


}

?>
