<?php
session_start();
if(isset($_SESSION['connection']))
{
    echo(json_encode($_SESSION['connection']));
}
else
{
    $result = new \stdClass();
    $result->active=false;
    $result->message='No connection found in current session';
    $result->token = rand();
    $result->time = $_SERVER['REQUEST_TIME'];

    echo(json_encode($result));
}
?>