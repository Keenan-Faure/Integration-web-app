<?php
session_start();
if(isset($_SESSION['credentials']) && isset($_SESSION['connection']))
{
    if($_SESSION['credentials']->active == true)
    {
        if($_SESSION['connection']->active == true)
        {
            //variable product
            if(isset($_POST['opt1_name']) && isset($_POST['opt1_value']))
            {
                
            }
            //simple product
            else
            {

            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->active = false;
            $variable->message = 'No connection found in current session, please re-connect';
            $variable->failedPage = 'process.php';
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

            echo(json_encode($variable));
            array_push($_SESSION['log'], $variable);
            header('Refresh:2,url=serverData.php');
        }
    }
    else
    {
        $variable = new \stdClass();
        $variable->active = false;
        $variable->message = 'No connection to MySQL server detected!';
        $variable->failedPage = 'process.php';
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

        echo(json_encode($variable));
        array_push($_SESSION['log'], $variable);
        header('Refresh:2,url=login.php');
    }
}
else
{
    $variable = new \stdClass();
    $variable->active = false;
    $variable->message = 'No connection to MySQL server detected!';
    $variable->failedPage = 'process.php';
    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

    echo(json_encode($variable));
    array_push($_SESSION['log'], $variable);
    header('Refresh:2,url=login.php');
}

?>