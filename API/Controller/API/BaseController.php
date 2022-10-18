<?php

namespace controller;

class Controller
{
    private $url = '/API/v1.php';

    function __call($method, $args)
    {
        //wont use any of the parameter defined in $method, $args
        $variable = new \stdClass();
        $variable->result = array();
        $variable->error = new \stdClass();
        $variable->error->errorcode = 404;
        $variable->error->errormessage = 'HTTP/1.1 404 Not Found';
        header('HTTP/1.0 404 Not Found');
        return $variable;
    }

    function endpoints($serverconnection)
    {
        if($_SESSION['apicredentials']->active === true && $serverconnection === true)
        {
            $variable = new \stdClass();
            $variable->result = true;
            $variable->url = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl();
            $variable->description = 'MySql API';
            $variable->version = 'v1.0.1';
            $variable->accepted_headers = ['GET', 'POST'];
            
            $variable->routes = new \stdClass();
            //product endpoints
            $variable->routes->products = new \stdClass();
            $variable->routes->products->getProductBySKU = new \stdClass();
            $variable->routes->products->getProductBySKU->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/products/<sku>";
            $variable->routes->products->getProductBySKU->accepts_data = true;

            $variable->routes->products->getProducts = new \stdClass();
            $variable->routes->products->getProducts->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/products";
            $variable->routes->products->getProducts->accepts_data = false;

            $variable->routes->products->countProducts = new \stdClass();
            $variable->routes->products->countProducts->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/products/count";
            $variable->routes->products->countProducts->accepts_data = false;
            //$variable->routes->products->addProduct

            //customer endpoints
            $variable->routes->customers = new \stdClass();
            $variable->routes->customers->getCustomerById = new \stdClass();
            $variable->routes->customers->getCustomerById->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/customers/<id>";
            $variable->routes->customers->getCustomerById->accepts_data = true;

            $variable->routes->customers->countCustomers = new \stdClass();
            $variable->routes->customers->countCustomers->endpoint = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/customers/count";
            $variable->routes->customers->countCustomers->accepts_data = false;

            $variable->routes->utility = new \stdClass();
            $variable->routes->utility->checkConnection = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/checkConnection";
            $variable->routes->utility->checkSN = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/checkSN";
            $variable->routes->utility->checkTables = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/checkTables";
            $variable->routes->utility->checkDatabases = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/checkDatabases";
            $variable->routes->utility->log = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/log";
            $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

            return $variable;
        }
    }

    //handles products endpoints
    function products($rawConnection, $connection, $segment = null)
    {

        if($_SESSION['apicredentials']->active === true)
        {
            if(isset($segment))
            {
                if($segment == 'count')
                {
                    $query = "SELECT COUNT(*) as 'Count' FROM Inventory";
                    $output = $connection->converterObject($rawConnection, $query);
                    return $output;
                }
                $query = "SELECT * FROM Inventory" . " WHERE SKU='" . $segment . "'";
                $output = $connection->converterObject($rawConnection, $query);
                return $output;
            }
            else
            {
                $query = "SELECT * FROM Inventory LIMIT 15";
                $output = $connection->converterObject($rawConnection, $query);
                return $output;
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->connection = false;
            $variable->error = "Failed to connect to API";
            $variable->message = "Either no credentials were entered, or incorrect matches were given";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            
            return $variable;
        }
    }

    //handles the customer endpoints
    function customers($rawConnection, $connection, $segment = null)
    {
        if($_SESSION['apicredentials']->active === true)
        {
            if(isset($segment))
            {
                if($segment == 'count')
                {
                    $query = "SELECT COUNT(*) as 'Count' FROM Client";
                    $output = $connection->converterObject($rawConnection, $query);
                    return $output;
                }
                $query = "SELECT * FROM Client WHERE ID='" . $segment . "'";
                $output = $connection->converterObject($rawConnection, $query);
                return $output;
            }
            else
            {
                $query = "SELECT * FROM Client LIMIT 15";
                $output = $connection->converterObject($rawConnection, $query);
                return $output;
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->connection = false;
            $variable->error = "Failed to connect to API";
            $variable->message = "Either no credentials were entered, or incorrect matches were given";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            
            return $variable;
        }
        
    }

    function utility($rawConnection, $connection, $segment = null)
    {
        if($_SESSION['apicredentials']->active === true)
        {
            if(isset($segment))
            {
                if($segment == 'checkConnection')
                {
                    return $connection;
                }
                elseif($segment == 'viewLog')
                {
                    $variable = new \stdClass();
                    $variable->result = true;
                    $variable->log = $_SESSION['log'];
                    return $variable;
                }
                else if($segment == 'visitS2S')
                {
                    header('Refresh:0, url=https://Stock2Shop.com');
                    $variable = new \stdClass();
                    $variable->message = 'Redirecting...';
                    return $variable;
                }
                else if($segment == 'checkTables')
                {
                    $query = "show tables";
                    $output = $connection->converterObject($rawConnection, $query);
                    return $output;
                }
                else if($segment == 'checkDatabases')
                {
                    $query = "show Databases";
                    $output = $connection->converterObject($rawConnection, $query);
                    return $output;;
                }
                else
                {
                    $variable = new \stdClass();
                    $variable->connection = false;
                    $variable->error = "Incorrect endpoint entered";
                    return $variable;
                }
            }
            else
            {
                $variable = new \stdClass();
                $variable->url = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl();
                $variable->description = 'MySql API';
                $variable->version = 'v1.0.1';
                $variable->result = true;
                $variable->routes = new \stdClass();
                $variable->routes->utility = new \stdClass();
                $variable->routes->utility->checkConnection = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "checkConnection";
                $variable->routes->utility->checkTables = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "checkTables";
                $variable->routes->utility->checkDatabases = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "checkDatabases";
                $variable->routes->utility->viewLog = "http://" . $_SERVER['HTTP_HOST'] . $this->baseUrl() . "/viewLog";
                $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                return $variable;
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->error = "Failed to connect to API";
            $variable->message = "Either no credentials were entered, or incorrect matches were given";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            
            return $variable;
        }
    }
    function baseUrl()
    {
        return $this->url;
    }
}

?>
