<?php
session_start();
if(isset($_SESSION['clearCache']))
{
    $variable = new \stdClass();
    $variable->clearCache = new \stdClass();
    $variable->clearCache->result = $_SESSION['clearCache'];
    $variable->clearCache->token = rand();

    $variable->message = 'Session data cleared, redirecting to login page in 5 seconds';
    echo(json_encode($variable));
    header('Refresh:5; url=serverData.php');

}
else
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
?>