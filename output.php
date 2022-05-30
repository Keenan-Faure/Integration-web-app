<?php
session_start();
if(isset($_POST['uname']) && isset($_POST['dbName']))
{
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
}
else
{
    $variable = new \stdClass();
    $variable->clearCache = new \stdClass();
    $variable->clearCache->result = $_SESSION['clearCache'];
    $variable->clearCache->token = rand();
    $variable->message = 'Session data cleared';
    echo(json_encode($variable));
    $_SESSION['clearCache'] = null;
    if(isset($_SESSION['connection']))
    {
        echo('?_? inside 1st');
        if($_SESSION['connection'] === true)
        {
            echo('?_? inside 2nd');
            $result = new \stdClass();
            $result->active=false;
            $result->message='No connection found in current session';
            $result->token = rand();
            $result->time = $_SERVER['REQUEST_TIME'];

            $_SESSION['connection'] = $result;
        }
    }
    $variable = new \stdClass();
    $variable->message = 'Session variables destroyed';
    $variable->timestamp = $_SERVER['REQUEST_TIME'];
    array_push($_SESSION['log'], $variable);
}
?>