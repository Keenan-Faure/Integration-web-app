<?php
session_start();
include('createConnection.php');

use Connection\Connection as connect;
if(isset($_POST['uname']) && isset($_POST['psw']))
{
    $serverConnection = new connect();
    $result = $serverConnection->connectServer($_POST['uname'], $_POST['psw']);
    if($result->connection === false)
    {
        $variable = new \stdClass();
        $variable->username = $_POST['uname'];
        $variable->password = $_POST['psw'];
        $variable->message = $result->message;
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        array_push($_SESSION['log'], $variable);
        header('Content-Type: application/json');
        header('Refresh:3,url=login.php');
    }
    else
    {
        $variable = new \stdClass();
        $variable->active = true;
        $variable->username = $_POST['uname'];
        $variable->password = $_POST['psw'];
        $_SESSION['credentials'] = $variable;
        $variable->message = 'Connection to MySql Server Successfull';
        $variable->redirectTime = '2 seconds';
        $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        unset($_POST['uname']);
        unset($_POST['psw']);
        array_push($_SESSION['log'], $variable);
        header('Refresh:0,url=serverData.php');
    }
}
else
{
    if(isset($_POST['api-name']) && isset($_POST['api-password']))
    {
        $variable = new connect();

        $connection = $variable->connectServer($_POST['api-name'], $_POST['api-password']);
        if($connection->connection == false)
        {
            $variable = new \stdClass();
            $variable->message = 'Incorrect credentials';
            $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            echo(json_encode($variable));
            header('Content-Type: application/json');
            header('Refresh:2,url=API/index.php');
        }
        if($connection->connection == true)
        {
            $variable = new \stdClass();
            $variable->credentials = new \stdClass();
            $variable->active = true;
            $variable->credentials->apiUsername = $_POST['api-name'];
            $variable->credentials->apiPassword = '*******';
            $_SESSION['apicredentials'] = $variable;
            header('Refresh:0,url=API/api.php');
        }
        else
        {
            die();
        }
        unset($_POST['api-name']);
        unset($_POST['api-password']);
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
                    array_push($_SESSION['log'], $connection);
                    die();
                }
                if($_SESSION['connection']->active === true)
                {
                    array_push($_SESSION['log'], $connection);
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
                array_push($_SESSION['log'], $variable);
                
            }
            if(!isset($_SESSION['serverconnection']))
            {
                $variable->message = "No connection to database found in current session";
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                header('Content-Type: application/json');
                echo(json_encode($variable));
                array_push($_SESSION['log'], $variable);
                
            }
        }
    }

}
//The form on Create Connection should be used to connect to the database,
//if the database is not found it should return the user to the serverData.php 
?>