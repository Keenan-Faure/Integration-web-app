<?php
session_start();
include('createConnection.php');

use Connection\Connection as connect;

$username = $_POST['uname'];
$password = $_POST['psw'];
$host = $_POST['host'];
$dbname = $_POST['dbName'];

$variable = new connect();
array_push($_SESSION['log'], $variable->createConnection($username, $password, $host, $dbname));
if($_SESSION['connection']->active === true)
{
    header('location: endpoints.php');
}
?>