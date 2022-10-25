<?php
session_start();
include('createConnection.php');
$_config = include('config/config.php');

use Connection\Connection as connect;
if(isset($_POST['uname']) && isset($_POST['psw']))
{
    //uses the token to decide whether 
    //to login or not
    if(isset($_SESSION['connection']->token))
    {
        header("Refresh:0, url=endpoints.php");
    }
    else
    {
        $serverConnection = new connect();
        $result = $serverConnection->connectUser($_config, $_POST['uname'], $_POST['psw']);
        if($result->connection === false)
        {
            $variable = new \stdClass();
            $variable->username = $_POST['uname'];
            $variable->password = $_POST['psw'];
            $variable->message = $result->message;
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            if(isset($_SESSION['log']))
            {
                array_push($_SESSION['log'], $variable);
            }
            echo(json_encode($variable));
            header('Content-Type: application/json');
            header('Refresh:3,url=login.php');
        }
        else
        {
            unset($_POST['uname']);
            unset($_POST['psw']);
            if(isset($_SESSION['log']))
            {
                array_push($_SESSION['log'], $result);
            }
            header('Refresh:0,url=endpoints.php');
        }
    }
}
else if(isset($_POST['runame']) && isset($_POST['rpsw']))
{

    $conn = new connect();

    $query = 'SELECT COUNT(*) as total FROM Users WHERE Username = "' . $_POST['runame'] . '"';
    $result = $conn->preQuery($_config, $query, 'object');
    if($result->result[0]->total > 0)
    {
        $message = 'User ' . $_POST['runame'] . ' already exists in database';
        $solution = 'Click the button below to return to the login page and try again';
        $conn->createHtmlMessages($message, $solution, 'register', 'warn');
        exit();
    }
    else
    {
        $query = 'INSERT INTO Users(
            Username,
            Password,
            Email
        )
        VALUES("'
            . $_POST["runame"] . '","'
            . $_POST["rpsw"] . '","'
            . $_POST["mail"] . '"
        )';
        $conn->preQuery($_config, $query, 'object');
    
        //creates html message
        $message = 'User ' . $_POST['runame'] . ' was created successfully';
        $solution = 'Click the button below to return to the login page';
        $conn->createHtmlMessages($message, $solution, 'login', 'info');
        exit();
    }
}
else
{
    if(isset($_POST['token']) && isset($_POST['secret']))
    {
        $variable = new connect();
        $connection = $variable->connectAPI($_POST['token'], $_POST['secret']);
        if($connection->active == false)
        {
            echo(json_encode($connection));
            header('Refresh:2,url=API/index.php');
        }
        if($connection->active == true)
        {
            $variable = new \stdClass();
            $variable->credentials = new \stdClass();
            $variable->active = true;
            $variable->credentials->token = $_POST['token'];
            $variable->credentials->secret = '*******';
            $_SESSION['apicredentials'] = $variable;
            $_SERVER['PHP_AUTH_USER'] = $_POST['token'];
            $_SERVER['PHP_AUTH_PSW'] = $_POST['secret'];
            header('Refresh:0,url=API/api.php');
        }
        else
        {
            die();
        }
        unset($_POST['token']);
        unset($_POST['secret']);
    }
    else
    {
        if(isset($_SESSION['credentials']) && $_SESSION['serverconnection']->active === true)
        {
            if($_SESSION['serverconnection']->active === true)
            {
                $username = $_SESSION['credentials']->username;
                $password = $_SESSION['credentials']->password;
                $host = $_POST['host'];
                $dbname = $_POST['dbName'];

                $variable = new connect();
                $connection = $variable->createConnection($username, $password, 'localhost', $dbname);
                if($connection->active == false)
                {
                    header('Content-Type: application/json');
                    echo(json_encode($connection));
                    if(isset($_SESSION['log']))
                    {
                        array_push($_SESSION['log'], $connection);
                    }
                    die();
                }
                if($_SESSION['connection']->active === true)
                {
                    if(isset($_SESSION['log']))
                    {
                        array_push($_SESSION['log'], $connection);
                    }
                    header('location: endpoints.php');
                }
            }
        }
        else
        {
            $variable = new \stdClass();
            if(!isset($_SESSION['credentials']))
            {
                $variable->message = "No login details found in current session";
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                header('Content-Type: application/json');
                echo(json_encode($variable));
                if(isset($_SESSION['log']))
                {
                    array_push($_SESSION['log'], $variable);
                }
            }
            else if(!isset($_SESSION['serverconnection']))
            {
                $variable->message = "No connection to database found in current session";
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                header('Content-Type: application/json');
                echo(json_encode($variable));
                if(isset($_SESSION['log']))
                {
                    array_push($_SESSION['log'], $variable);
                }    
            }
        }
    }

}
?>