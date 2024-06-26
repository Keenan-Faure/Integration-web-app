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
    $url = 'https://app.stock2shop.com/v1/queue/items?token=' . $_POST["token"] . '&limit=' . $_POST["limit"] . '&mode=' . $_POST["mode"] . '&search_mode=' . $_POST["search_mode"] . '&instruction=' . $_POST["instruction"] . '&status=' . $_POST["status"];
    if($_POST["source_id"]) {
        $url .= '&source_id=' . $_POST["source_id"];
    }
    if($_POST["channel_id"]) {
        $url .= '&channel_id=' . $_POST["channel_id"];
    }
    $queue_response = $curl->get_web_page($url, "", "", "", "");
    $json_response = json_decode($queue_response);
    if(isset($json_response->system_items)) {
        // for loop
        if($_POST["enable_retry"] != "yes") {
            print_r($queue_response);
            exit;
        }
        $actual_response_data = new \stdClass();
        $actual_response_data->system_items = [];
        $actual_response_data_count = 0;
        foreach($json_response->system_items as $queue_item) {
            if($queue_item->log_message == $_POST["error_message"] && $queue_item->created > $_POST["date_limit"]) {
                array_push($actual_response_data->system_items, $queue_item);
            }
        }
        foreach ($actual_response_data->system_items as $queue_id) {
            // print_r("inside for loop");
            // print_r($queue_id->id);
            if($_POST["enable_retry"] == "yes") {
                // print_r("inside enable_retry");
                // print_r("queue_item message: " . $queue_id->log_message);
                // print_r($_POST["error_message"]);
                // print_r("created_at: "  . $queue_id->created);
                // print_r("date_limit: " . $_POST["date_limit"]);
                // print_r("<br>");
                $reset_url = "https://app.stock2shop.com/v1/queue/reset/" . $queue_id->id . "?token=" . $_POST["token"];
                $reset_response = $curl->get_web_page($reset_url, "", "", "", "put");
                $json_reset_response = json_decode($reset_response);
                $response->{$queue_id->id} = $json_reset_response->id;
            }
        }
        $response->retry_counter = count($actual_response_data->system_items);
        print_r(json_encode($response));
    } else {
        $error->message = "system items is not set inside the queue response";
        print_r(json_encode($error));
    }
     
?>