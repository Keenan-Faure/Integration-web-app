<?php
session_start();
include('createConnection.php');
use Connection\Connection as connect;
$conn = new connect();

$host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
$fullUrl = $_SERVER["REQUEST_URI"];
$fullUrl = $host . $fullUrl;
if(isset(($conn->queryParams($fullUrl))['q']))
{
    if(($conn->queryParams($fullUrl))['q'] == 'session')
    {
        $query = ($conn->queryParams($fullUrl))['q'];
        $message = 'Username: ' . $_SESSION['clientConn']->credentials->username . '<br>' . 'Password: ' . $_SESSION['clientConn']->credentials->password . '<br>' . 'dbName: ' . $_SESSION['clientConn']->credentials->dbname . '<br>' . 'Token: ' . $_SESSION['clientConn']->token;
        $conn->createHtmlMessages('Session details', $message, 'endpoints', 'info');
        exit();
    }
    else if(($conn->queryParams($fullUrl))['q'] == 'clearLog')
    {
        $query = "DELETE FROM Logs";
        $connection = $conn->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $output = $conn->converterObject($connection, $query);
        $message = "Logs have been successfully cleared";
        $conn->createHtmlMessages('Clear Logs', $message, 'endpoints', 'info');
        exit();
    }
}

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
    $host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
    $fullUrl = $_SERVER["REQUEST_URI"];
    $fullUrl = $host . $fullUrl;
    $params = $conn->queryParams($fullUrl)['logout'];
    if($params == true)
    {
        session_destroy();
        $conn->createHtmlMessages('User logged out', 'Returning to login page', 'login', 'info');
        header('Refresh:2, url=login.php');
    }
}
?>