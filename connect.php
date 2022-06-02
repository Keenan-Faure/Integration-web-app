<?php
session_start();
include('createConnection.php');

use Connection\Connection as connect;

if(isset($_POST['uname']) && isset($_POST['psw']))
{
    $variable = new \stdClass();
    $variable->username = $_POST['uname'];
    $variable->password = $_POST['psw'];
    $_SESSION['credentials'] = $variable;
    $variable->message = 'Login to MySql Server successful';
    $variable->redirecttime = '2 seconds';
    $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
    unset($_POST['uname']);
    unset($_POST['psw']);

    $log = new \stdClass();
    $log->message = 'logged credentials';
    $log->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);;
    array_push($_SESSION['log'], $log);
    header('Refresh:0,url=serverData.php');
}
else
{
    if(isset($_SESSION['credentials']) && $_SESSION['connection']->active === true)
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
    else
    {
        $variable = new \stdClass();
        $variable->message = "No login details found in current session";
        $variable->connection = $_SESSION['connection']->message;
        echo(json_encode($variable));
        header('Refresh:1,url=login.php');
    }

}
?>