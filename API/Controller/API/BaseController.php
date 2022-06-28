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
            time:
        }
        */
        if($_SESSION['apicredentials']->active === true && $serverconnection === true)
        {
            $variable = new \stdClass();
            $variable->result = true;
            $variable->url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $variable->description = 'MySql API';
            $variable->version = 'v1.0.1';
            $variable->routes = new \stdClass();

            //product endpoints
            $variable->routes->products = new \stdClass();
            $variable->routes->products->getProductBySKU = new \stdClass();
            $variable->routes->products->getProductBySKU->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/products/<sku>";
            $variable->routes->products->getProductBySKU->accepts_data = true;

            $variable->routes->products->getProducts = new \stdClass();
            $variable->routes->products->getProducts->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/products";
            $variable->routes->products->getProducts->accepts_data = false;

            $variable->routes->products->countProducts = new \stdClass();
            $variable->routes->products->countProducts->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/count";
            $variable->routes->products->countProducts->accepts_data = false;
            //$variable->routes->products->addProduct

            //customer endpoints
            $variable->routes->customers = new \stdClass();
            $variable->routes->customers->getProductBy = new \stdClass();
            $variable->routes->customers->getProductBySKU->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/customers/<sku>";
            $variable->routes->customers->getProductBySKU->accepts_data = true;

            $variable->routes->customers->getCustomers = new \stdClass();
            $variable->routes->customers->getCustomers->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/customers";
            $variable->routes->customers->getCustomers->accepts_data = false;

            $variable->routes->customers->countCustomers = new \stdClass();
            $variable->routes->customers->countCustomers->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/count";
            $variable->routes->customers->countCustomers->accepts_data = false;

            $variable->routes->utility = new \stdClass();
            $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
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
