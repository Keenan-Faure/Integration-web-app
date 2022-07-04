<?php
    session_start();
    if(!isset($_SESSION['log']))
    {
        $_SESSION['log'] = array();
    }
    include("../createConnection.php");
    use Connection\Connection as connect;
    use controller\Controller as control;
    if(!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_USER'])) 
    {
        header('WWW-Authenticate: Basic realm="Authorization"');
        header('HTTP/1.0 401 Unauthorized');
        header('Content-Type: application/json');
        $variable = new \stdClass();
        $variable->message = 'Unauthorized access, or credentials not provided';
        echo(json_encode($variable));
        header('Refresh:2, url=api.php');
        exit;
    } 
    else 
    {
        include("Controller/API/BaseController.php");
        header("Content-Type: application/json");
        $apiConn = new connect();
        $apiConn = $apiConn->connectServer($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], 'localhost');
        if($apiConn->connection)
        {
            $variable = new \stdClass();
            $variable->credentials = new \stdClass();
            $variable->active = true;
            $variable->credentials->token = $_SERVER['PHP_AUTH_USER'];
            $variable->credentials->secret = $_SERVER['PHP_AUTH_PW'];

            $_SESSION['apicredentials'] = $variable;
            //saves to log
            $variable = new \stdClass();
            $variable->message = "Successfully connected to API with: " . $_SESSION['apicredentials']->credentials->token . ": secret_" . $_SESSION['apicredentials']->credentials->secret;
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            array_push($_SESSION['log'], $variable);
            
            $url = parse_url($_SERVER['REQUEST_URI'])['path'];

            $url = explode('/', $url);
            //only if the 5th segment of the url is defined and populated
            //then run a function on it.
            if(isset($url[4]))
            {
                $segment = $url[4];
                print_r($segment);
            }

            //else display all url functions (endpoints)
            else
            {
                $variable = new control();
                echo(json_encode($variable->endpoints($_SESSION['serverconnection']->active)));
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->connection = false;
            $variable->error = "Failed to connect to API";
            $variable->message = "Either no credentials were entered, or incorrect matches were given";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            echo(json_encode($variable));
            header('WWW-Authenticate: Basic realm="Authorization"');

        }
    }
    ?>


<?php


    //if they have, then display all endpoints defined in a class/database maybe

    //else rediret user to index.php (api login)

    //fix tables, it has to check if that table exists, if it doesn't it should advise the person to query show tables;

    //scan through the sent URL, if it is what we expect then we can run a function based on that url. We have to create
    //Another class/file to define these functions, thinking of using Controller to store them in.

    //When setting the table, we need to add a check to confirm if the table has all basic product information, or if one has to be created. We should ask.
    /*
        SKU, Title, Description, product code, active field (when if), category, product-type, 
        Brand, options (name, value), variant code, weight, barcode, price, quantity.

    */
    

?>