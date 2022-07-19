<?php
session_start();
include("Class Templates/vProduct.php");
include("Class Templates/sProduct.php");
include("Class Templates/customer.php");
include("Class Templates/utility.php");

use sProducts\sProducts as sproduct;
use vProducts\vProducts as vproduct;
use customer\customer as customer;
use utils\Utility as util;

header("Content-Type: application/json");

if(isset($_SESSION['credentials']) && isset($_SESSION['connection']))
{
    if($_SESSION['credentials']->active == true)
    {

        if($_SESSION['connection']->active == true)
        {
            //variable product
            $util = new util();
            if(isset($_POST['optionName']) && isset($_POST['optionValue']))
            {
                $product = new vproduct();
                $result = $product->createProduct($_POST, $util);
                $result = $product->addProduct($result);
                echo(json_encode($result));
                header("Refresh:3, url='addItem.html'");


                //if statement to check if everything went well...
                //run a query against database to check if a product with similar data exists;
            }
            //simple product
            else
            {
                $product = new sproduct();
            
                //if statement to check if everything went well...
                //run a query against database to check if a product with similar data exists;



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