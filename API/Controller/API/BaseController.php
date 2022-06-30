<?php

namespace controller;

class Controller
{
    function __call($method, $args)
    {
        $variable = new \stdClass();
        $variable->result = array();
        $variable->error = new \stdClass();
        $variable->error->errorcode = '404';
        $variable->error->errormessage = 'HTTP/1.1 404 Not Found';
        $variable->rawMessage = $method . ' - ' . $args;

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
            $variable->routes->customers->getCustomerById = new \stdClass();
            $variable->routes->customers->getCustomerById->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/customers/<id>";
            $variable->routes->customers->getCustomerById->accepts_data = true;

            $variable->routes->customers->countCustomers = new \stdClass();
            $variable->routes->customers->countCustomers->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/count";
            $variable->routes->customers->countCustomers->accepts_data = false;

            $variable->routes->utility = new \stdClass();
            $variable->routes->utility->checkConnection = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/checkConnection";
            $variable->routes->utility->log = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "/log";
            $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

            return $variable;
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
