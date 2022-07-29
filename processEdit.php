<?php
session_start();
include("Class Templates/vProduct.php");
include("Class Templates/sProduct.php");
include("Class Templates/customer.php");
include("Class Templates/utility.php");
include('createConnection.php');

use sProducts\sProducts as sproduct;
use vProducts\vProducts as vproduct;
use customer\Customers as customer;
use utils\Utility as util;
use Connection\Connection as connect;
header("Content-Type: application/json");

if(isset($_SESSION['credentials']) && isset($_SESSION['connection']))
{
    if($_SESSION['credentials']->active == true)
    {

        if($_SESSION['connection']->active == true)
        {
            //variable product
            $util = new util();
            $connection = new connect();
            if(isset($_POST['name']) && isset($_POST['surname']))
            {
                //customer
                $customer = new customer();
                $result = $customer->createCustomer($_POST, $util, $connection);
                if(isset($result->return))
                {
                    echo(json_encode($result));
                    exit();
                }
                $result = $customer->addCustomer($result, $connection);
                echo(json_encode($result));
                unset($_POST);
            }
            else if(!isset($_POST['name']) && isset($_POST['sku']))
            {
                if(isset($_POST['optionName']) && isset($_POST['optionValue']))
                {
                    $product = new vproduct();
                    $result = $product->createProduct($_POST, $util, $connection, 'edit');
                    if(isset($result->return))
                    {
                        echo(json_encode($result));
                        exit();
                    }
                    $result = $product->updateProduct($result, $util, $connection);
                    echo(json_encode($result));
                    unset($_POST);
                }
                else
                {
                    //simple product
                    $product = new sproduct();
                    $result = $product->createProduct($_POST, $util, $connection, 'edit');
                    if(isset($result->return))
                    {
                        echo(json_encode($result));
                        exit();
                    }
                    $result = $product->updateProduct($result, $util, $connection);
                    echo(json_encode($result));
                    unset($_POST);
                }
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