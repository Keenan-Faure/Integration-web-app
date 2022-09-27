<?php
session_start();
include('cURL.php');
include("../createConnection.php");
use Connection\Connection as connect;
use cURL\CURL as curl;

//make condition statements for the various routes

if($_SESSION['connection']->active == true)
{
    $curl = new curl();
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
    else if($_POST['endpoint'] == 'pushProducts')
    {
        $connection = new connect();
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        
        //creates query
        //filters the query with conditions from the conditions table
        $queryCondition = "SELECT * FROM Conditions";
        $output = $connection->converterObject($rawConnection, $queryCondition);
        if(sizeof($output->result) == 0)
        {
            $query = "SELECT * FROM Inventory";
        }
        $query = $curl->createQuery($output);

        $output = $connection->converterObject($rawConnection, $query);
        if(sizeof($output->result) == 0)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->error = "No products found in Database > Inventory table. Check conditions and try again";
            $variable->message = "Cannot push null in Inventory table";
            echo(json_encode($variable));
            exit();
        }
        mysqli_close($rawConnection);

        //gets the source information, we'll only use the flatfile
        $sources = ($curl->getSources($_SESSION['token'],$_POST['username'], $_POST['password']));
        if($sources->httpcode == '200')
        {
            $pushed = new \stdClass();
            $pushed->system_products = array();
            for($i = 0; $i < sizeof($output->result); ++$i)
            {
                $data = $curl->addProduct($output->result[$i], $sources->system_sources[0]);
                if($data != null)
                {
                    array_push($pushed->system_products, $data);
                }
                else
                {
                    if(isset($_SESSION['log']))
                    {
                        $variable = new \stdClass();
                        $variable->result = false;
                        $variable->message = "Product with SKU " . $output->result[$i]->SKU . " was not processed";
                        $variable->data = $data;
                        array_push($_SESSION['log'], $variable);
                    }
                }
            }
            echo(json_encode($curl->push($pushed, $sources->system_sources[0], $_SESSION['token'], $_POST['username'], $_POST['password'])));
        }
        else
        {
            json_encode($curl->getSources($_SESSION['token'],'keenan.faure', 'Re_Ghoul'));
            exit();
        }
    }
}
else
{
    $variable = new \stdClass();
    $variable->active = false;
    $variable->message = 'No connection found in current session, please re-connect';
    $variable->failedPage = 'execute.php';
    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
    echo(json_encode($variable));
}
?>