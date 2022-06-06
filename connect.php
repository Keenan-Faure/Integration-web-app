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
        echo(json_encode($variable));
        header('Refresh:3,url=login.php');
    }
    else
    {
        $variable = new \stdClass();
        $variable->username = $_POST['uname'];
        $variable->password = '*****';
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
    if(isset($_SESSION['credentials']) && isset($_SESSION['connection']))
    {
        if($_SESSION['connection']->active)
        {
            $username = $_SESSION['credentials']->username;
            $password = $_SESSION['credentials']->password;
            $host = $_POST['host'];
            $dbname = $_POST['dbName'];

            $variable = new connect();
            array_push($_SESSION['log'], $variable->createConnection($username, $password, $host, $dbname));
            if($_SESSION['connection']->active === true)
            {
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
            echo(json_encode($variable));
            array_push($_SESSION['log'], $variable);
            header('Refresh:3,url=login.php');
        }
        if(!isset($_SESSION['connection']))
        {
            $variable->message = "No connection to database found in current session";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            echo(json_encode($variable));
            array_push($_SESSION['log'], $variable);
            header('Refresh:3,url=serverData.php');
        }
    }

}
//The form on Create Connection should be used to connect to the database,
//if the database is not found it should return the user to the serverData.php 
?>