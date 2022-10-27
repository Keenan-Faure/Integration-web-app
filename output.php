<?php
session_start();
include('createConnection.php');
use Connection\Connection as connect;
$conn = new connect();

if(isset($_SESSION['clientConn']) && isset($_POST['dbName']))
{   
    if(isset($_SESSION['connection']))
    {
        $conn->createHtmlMessages('Connected to ' . $_POST['dbName'], 'Status: Connection', 'endpoints', 'info');
    }
    else
    {
        $conn->createHtmlMessages('No connection to ' . $_POST['dbName'] . ' found in current session', 'Please relog', 'login', 'warn');
    }
}
else
{
    if(!isset($_SESSION['clientConn']))
    {
        $conn->createHtmlMessages('No connection to MySql server found in current session', 'Please relog', 'login', 'warn');
        header('Refresh:2,url=login.php');
    }
    else
    {
        $_SESSION['clearCache'] = true;
        session_destroy();
        $conn->addLogs('Logout', 'Session Data cleared', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', true);
        $conn->createHtmlMessages('Session data cleared', 'Logging-out', 'login', 'info');
        header("Refresh:3,url=login.php");
    }
}
?>