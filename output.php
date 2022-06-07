<?php
session_start();


if(isset($_SESSION['credentials']) && isset($_POST['dbName']))
{   
    if(isset($_SESSION['connection']))
    {
        echo(json_encode($_SESSION['connection']));
    }
    else
    {
        $result = new \stdClass();
        $result->active=false;
        $result->message='No connection to ' . $_POST['dbName'] . ' found in current session';
        $result->token = rand();
        $result->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);;
        echo(json_encode($result));
    }
}
else
{
    $_SESSION['clearCache'] = true;
    $variable = new \stdClass();
    $variable->clearCache = new \stdClass();
    $variable->clearCache->result = $_SESSION['clearCache'];
    $variable->clearCache->token = rand();
    $variable->message = 'Session data cleared';
    echo(json_encode($variable));
    if(isset($_SESSION['connection']))
    {
        if($_SESSION['connection']->active === true)
        {
            $result = new \stdClass();
            $result->active=false;
            $result->message='No connection found in current session';
            $result->token = rand();
            $result->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);;

            $_SESSION['connection'] = $result;
        }
    }
    $variable = new \stdClass();
    $variable->message = 'Session data destroyed';
    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);;
    if(isset($_SESSION['log']))
    {
        array_push($_SESSION['log'], $variable);
    }
    session_destroy();
    header("Refresh:3,url=login.php");
}
?>