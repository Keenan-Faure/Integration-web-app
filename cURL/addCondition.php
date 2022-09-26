<?php
session_start();
include("../createConnection.php");
use Connection\Connection as connect;

if($_SESSION['connection']->active == true)
{
    $connect = new connect();
    $credentials = $_SESSION['connection']->credentials;
    $connection = $connect->createConnection($credentials->username, $credentials->password, $credentials->host, $credentials->dbname)->rawValue;
    $query = 'select * from Conditions';
    $output = $connect->converterObject($connection, $query);
    $output = $output->result;
    print_r($output);

    //check if its empty
    //otherwise run checks if the current conditon exists already
    //if it does not then add it
    //add a way to display the conditions


}

//compares the conditions
function compareCondition($condition1, $condition2)
{
    //if($condition1->dataValue)
}

?>