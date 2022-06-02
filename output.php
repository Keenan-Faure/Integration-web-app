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
    echo("I am in the wrong place");
    $variable = new \stdClass();
    $variable->clearCache = new \stdClass();
    $variable->clearCache->result = $_SESSION['clearCache'];
    $variable->clearCache->token = rand();
    $variable->message = 'Session data cleared';
    echo(json_encode($variable));
    $_SESSION['clearCache'] = true;
    if(isset($_SESSION['credentials']))
    {
        unset($_SESSION['credentials']);
    }
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
    array_push($_SESSION['log'], $variable);

}
?>