<?php
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
            $variable->message = "Successfully connected to API";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            array_push($_SESSION['log'], $variable);
            
            $url = parse_url($_SERVER['REQUEST_URI'])['path'];

            $url = explode('/', $url);
            //only if the 5th segment of the url is defined and populated
            //then run a function on it.
            if(isset($url[4]))
            {
                $connection = new connect();
                $serverConnection = $connection->connectServer($_SESSION['apicredentials']->credentials->token, $_SESSION['apicredentials']->credentials->secret, 'localhost')->rawValue;
                $query = 'show DATABASES';
                $output = $connection->converterArray($serverConnection, $query, "Database");

                //closes connection
                mysqli_close($serverConnection);
                $knownDbs = array('information_schema', 'mysql', 'performance_schema', 'phpmyadmin', 'test');
                $output = array_diff($output, $knownDbs);

                //checks if there are more than one Databases on server
                //only uses the first one...
                if(sizeof($output) > 1)
                {
                    $variable = new \stdClass();
                    $variable->result = true;
                    $variable->message = "More than one Database detected";
                    $variable->currentDatabase = $output[0];
                    array_push($_SESSION['log'], $variable);
                }
                $database = $output[0];


                //starts new connection based on the Database taken
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['apicredentials']->credentials->token, $_SESSION['apicredentials']->credentials->secret, 'localhost', $database)->rawValue;
                //creates query
                $query = "show tables;";
                
                $output = $connection->converterObject($rawConnection, $query);

                $variable = new control();
                //if the URL length is longer than expected...
                if(sizeof($url) > 6)
                {
                    $variable = new \stdClass();
                    $variable->data = new \stdClass();
                    $variable->data->result = false;
                    $variable->data->error = "Endpoint not defined";
                    $variable->url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $variable->description = 'MySql API';
                    $variable->version = 'v1.0.1';
                    header("HTTP/1.1 404 Not Found");
                    echo(json_encode($variable));
                }
                else
                {
                    //uses the 5th arrayField as a search in the database using the 4th arrayField as a reference
                    if(isset($url[5]))
                    {
                        $segment = $url[4];
                        echo(json_encode($variable->{$segment}($url[5], $rawConnection, $connection)));
                    }
                    
                    //gets a batch
                    else
                    {
                        $segment = $url[4];
                        echo(json_encode($variable->{$segment}(null, $rawConnection, $connection)));
                    }
                }
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