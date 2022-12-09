<?php

session_start(); 

if(isset($_SESSION['connection']))
{
    echo(json_encode($_SESSION['clientConn']));
}
else
{
    $variable = new \stdClass();
    $variable->return = false;
    $variable->body = "No session found";
    echo(json_encode($variable));
}
?>