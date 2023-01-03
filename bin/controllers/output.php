<?php
session_start();
include('../../Class Templates/createConnection.php');
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
        $conn->createHtmlMessages('', 'Session details', $message, 'dashboard', 'info');
        exit();
    }
    else if(($conn->queryParams($fullUrl))['q'] == 'clearLog')
    {
        $query = "DELETE FROM Logs";
        $connection = $conn->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $output = $conn->converterObject($connection, $query);
        $message = "Logs have been successfully cleared";
        $conn->createHtmlMessages('', 'Method: Clear logs', $message, 'dashboard', 'info');
        exit();
    }
    else if(($conn->queryParams($fullUrl))['q'] == 'showTbl')
    {
        $connection = new connect();
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        
        //creates query
        $query = "show tables";
        
        $output = $connection->converterObject($rawConnection, $query);
        mysqli_close($rawConnection);
        $conn->createJsonMessages('Method: Display Tables', json_encode($output, JSON_PRETTY_PRINT), '../../dashboard', 'info', 'php');
        exit;
    }
    else if(($conn->queryParams($fullUrl))['q'] == 'checkConn')
    {
        $conn->createJsonMessages('Method: Display Connection', json_encode($_SESSION['connection'], JSON_PRETTY_PRINT), '../../dashboard', 'info', 'php');
        exit();
    }
    else if(($conn->queryParams($fullUrl))['q'] == 'viewLog')
    {
        $conn->createJsonMessages('Method: View logs', json_encode($_SESSION['log'], JSON_PRETTY_PRINT), '../../dashboard', 'info', 'php');
        exit();
    }
}

if(isset($_SESSION['clientConn']) && isset($_POST['dbName']))
{   
    if(isset($_SESSION['connection']))
    {
        $conn->createHtmlMessages('', 'Connected to ' . $_POST['dbName'], 'Status: Connection', 'dashboard', 'info');
    }
    else
    {
        $conn->createHtmlMessages('', 'No connection to ' . $_POST['dbName'] . ' found in current session', 'Please relog', 'login', 'warn');
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
        $conn->createHtmlMessages('', 'User logged out', 'Returning to login page', 'login', 'info');
        header('Refresh:0.5, url=../../auth/login.php');
    }
}
?>