<?php
session_start();
include('cURL.php');
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;
use cURL\CURL as curl;

//make condition statements for the various routes

if($_SESSION['connection']->active == true)
{
    $curl = new curl();
    $connection = new connect();

    //credentials
    $_woo_settings = json_encode($_SESSION['woo_settings']);

    if($_POST['endpoint'] == 'authenticate')
    {
        //if success then do something
        $result = $curl->authenticate($_POST['username'], $_POST['password']);
        if($result->httpcode != '200' || isset($result->errors))
        {
            echo(json_encode($result));
            exit();
        }
        $_SESSION['token'] = $result->system_user->token;
        echo(json_encode($result));
    }
    else if($_POST['endpoint'] == 'validToken')
    {
        echo(json_encode($curl->validateToken($_SESSION['token'],$_POST['username'], $_POST['password'])));
    }
    else if($_POST['endpoint'] == 'getSources')
    {
        echo(json_encode($curl->getSources($_SESSION['token'],$_POST['username'], $_POST['password'])));
    }
    else if($_POST['endpoint'] == 'getChannels')
    {
        echo(json_encode($curl->getChannels($_SESSION['token'],$_POST['username'], $_POST['password'])));
    }
    else if($_POST['endpoint'] == 'elastic_query')
    {
        echo(json_encode($curl->elastic_query('',$_SESSION['token'],$_POST['username'], $_POST['password'])));
    }
    //create button to do this...
    // else if($_POST['endpoint'] == 'pushProducts')
    // {
        
    // }

    //Woocommerce Endpoints
    else if(str_contains($_POST['endpoint'], 'woo_') != false)
    {
        header('Content-Type: application/json');
        $func = str_replace('woo_','', $_POST['endpoint']);
        echo(($curl->$func()));
    }
}
else
{
    $conn = new connect();
    $conn->createHtmlMessages('Error connecting to user session', 'No connection found in current session, please re-connect', 'login', 'info');
}
?>