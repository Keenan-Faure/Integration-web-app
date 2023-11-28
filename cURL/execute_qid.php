<?php
session_start();
include('cURL.php');
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;
use cURL\CURL as curl;

    $curl = new curl();
    $connection = new connect();

    // fetch s2s queue items
    // https://app.stock2shop.com/v1/queue/items?source_id=1290&limit=50&mode=non-blocking&search_mode=products&instructions=add_product&status=failed&token=CPDKMPUT3N62401X2VULRXY3T4IKD3U6PSUCJXPR

    $error = new \stdClass();
    $response = new \stdClass();

    $url = 'https://app.stock2shop.com/v1/queue/items?token=' . $_POST["token"] . '&source_id=' . $_POST["source_id"] . '&limit=' . $_POST["limit"] . '&mode=' . $_POST["mode"] . '&search_mode=' . $_POST["search_mode"] . '&instruction=' . $_POST["instruction"] . '&status=' . $_POST["status"];
    $queue_response = $curl->get_web_page($url, "", "", "", "");
    $json_response = json_decode($queue_response);
    if(isset($json_response->system_items)) {
        // for loop
        if($_POST["enable_retry"] != "yes") {
            print_r($queue_response);
            exit;
        }
        $counter = (int) $_POST["retry_counter"];
        for ($i = 0; $i < $counter; ++$i) {
            $queue_id = $json_response->system_items[$i];
            if($_POST["enable_retry"] == "yes") {
                if($queue_id->log_message == $_POST["error_message"]) {
                    $reset_url = "https://app.stock2shop.com/v1/queue/reset/" . $queue_id->id . "?token=" . $_POST["token"];
                    $reset_response = $curl->get_web_page($reset_url, "", "", "", "put");
                    $json_reset_response = json_decode($reset_response);
                    $response->{$queue_id->id} = $json_reset_response->id;
                }
            }
        }
        print_r(json_encode($response));
    } else {
        $error->message = "system items is not set inside the queue response";
        print_r(json_encode($error));
    }
     
?>