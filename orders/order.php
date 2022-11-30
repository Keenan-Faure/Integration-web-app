<?php

    include("../Class Templates/createConnection.php");
    include("../Class Templates/utility.php");
    include("../Class Templates/orders.php");
    $_settings = json_decode(json_encode(include("../config/config.php")), false);
    $_woo_settings = include("../config/woo_settings.php");

    use Connection\Connection as connect;
    use utils\Utility as util;
    use orders\Orders as orders;

    $conn = new connect();
    $order = new orders();
    $util = new util();

    $_woo_settings = $conn->setSettings($_woo_settings);

    //gets all order headers from URL
    $headers = json_decode(json_encode(getallheaders()), FALSE);
    $requestBody = file_get_contents('php://input');

    //verify data sent using headers
    $webHookRegistered = $order->verifyWebhook($requestBody, $headers, $_woo_settings);

    if($webHookRegistered == true)
    {

        $requestBody = json_decode($requestBody);

        //check if the order is already found in the database
        $exists = $order->checkOrderExist($requestBody->order->id, $conn, $_settings);
        if($exists == true)
        {
            //update existing order
            $order->updateOrder($requestBody, $conn, $_settings);
        }
        else
        {
            //add new order
            $order->addOrder($requestBody, $conn, $_settings);
        }
    }
    // else
    // {
    //     //records it in logs
    //     $conn->addLogs('Failed to sync order from Woocommerce', $webHookRegistered, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true);
    // }

    //$util->writeToFile('output', 'w', ($text));
    // $util->writeToFile('output1', 'w', ($webhook));

?>