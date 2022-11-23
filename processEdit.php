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

if(isset($_SESSION['connection']) && isset($_SESSION['connection']))
{
    if($_SESSION['connection']->active == true)
    {

        if($_SESSION['connection']->active == true)
        {
            //variable product
            $util = new util();
            $connection = new connect();
            if(isset($_POST['name']) && isset($_POST['surname']))
            {
                if(!isset($_POST['active']))
                {
                    $_POST['active'] = 'false';
                }
                if($_POST['name'] != null && $_POST['surname'] != null)
                {
                    $customer = new customer();
                    $post = $_POST;
                    $result = $customer->createCustomer($_POST, $util, $connection, 'edit');

                    if(isset($result->return))
                    {
                        echo(json_encode($result));
                        exit();
                    }
                    $result = $customer->updateCustomer($result, $util, $connection);
                    //echo(json_encode($result));
                    header('Refresh:1, url=customerList.php?page=1');
                    unset($_POST);
                }
            }
            else if(!isset($_POST['name']) && isset($_POST['sku']))
            {
                if(!isset($_POST['active']))
                {
                    $_POST['active'] = 'false';
                }
                if(($_POST['optionName'] != null && $_POST['optionValue'] != null) && ($_POST['optionName'] != 'null' && $_POST['optionValue'] != 'null'))
                {
                    //variable product
                    $product = new vproduct();
                    $result = $product->createProduct($_POST, $util, $connection, 'edit');
                    if(isset($result->return))
                    {
                        echo(json_encode($result));
                        header('Refresh:1, url=productList.php?page=1');
                        exit();
                    }
                    $result = $product->updateProduct($result, $util, $connection);
                    //echo(json_encode($result));
                    header('Refresh:0, url=productList.php?page=1');
                    unset($_POST);
                }
                else
                {
                    //simple product
                    $product = new sproduct();
                    $post = $_POST;
                    $result = $product->createProduct($_POST, $util, $connection, 'edit');
                    if(isset($result->return))
                    {
                        echo(json_encode($result));
                        exit();
                    }
                    $result = $product->updateProduct($result, $util, $connection);
                    //echo(json_encode($result));
                    header('Refresh:0, url=productList.php?page=1');
                    unset($_POST);
                }
            }
            
        }
        else
        {
            $conn = new connect();
            $conn->addLogs('Error connecting', 'No connection found in current session, please re-connect', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
            $conn->createHtmlMessages('Error connecting', 'No Session was detected', 'login', 'info');

            header('Refresh:1,url=login.php');
        }
    }
    else
    {
        $conn = new connect();
        $conn->addLogs('Error connecting', 'No login data found for current user', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
        $conn->createHtmlMessages('Error connecting to user session', 'No Session User was detected', 'login', 'info');
        header('Refresh:1,url=login.php');
    }
}
else
{
    $conn = new connect();
    $conn->addLogs('Error connecting', 'No login data found for current user', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
    $conn->createHtmlMessages('Error connecting to user session', 'No Session User was detected', 'login', 'info');
    header('Refresh:1,url=login.php');
}

?>