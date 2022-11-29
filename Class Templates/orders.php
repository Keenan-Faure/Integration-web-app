<?php

namespace orders;

Class Orders
{
    //adds the order to the database
    function addOrder($orderBody, $connection)
    {
        
    }

    //updates the order
    function updateOrder()
    {

    }

    //checks if the order already exists in the database
    //returns false is the order is not found
    //and true when it is
    function checkOrderExist($order_id, $connection, $_settings)
    {
        $query = "SELECT * FROM Orders WHERE ID = '" . $order_id . "'";
        $rawConnection = $connection->createConnection($_settings->dbUser, $_settings->dbPass, 'localhost', $_settings->dbName)->rawValue;
        $output2 = $connection->converterObject($rawConnection, $query, $_settings->dbName);
        if($output2->result == null)
        {
            return false;
        }
        else
        {
            return true;
        }

    }

    //verifies the webhook using the headers received
    //checks if the resource is an order
    //checks if the Signature is correct
    function verifyWebhook($requestBody, $headers, $_wooSettings)
    {
        if(isset($headers->{'X-Wc-Webhook-Resource'}) && isset($headers->{'X-Wc-Webhook-Source'}))
        {
            if($headers->{'X-Wc-Webhook-Resource'} == 'order')
            {
                if($headers->{'X-Wc-Webhook-Source'} == ('https://' . $_wooSettings->Woocommerce_Store->store_name . '/'))
                {
                    if($_wooSettings->Woocommerce_Settings->woo_enable_hmac_decoding == "true")
                    {
                        $signature = base64_encode(hash_hmac('sha256', $requestBody, $_wooSettings->Woocommerce_Store->webhook_secret, true));
                        if($headers->{'X-Wc-Webhook-Signature'} == $signature)
                        {
                            return true;
                        }
                        else
                        {
                            return false;
                        }
                    }
                    else
                    {
                        return true;
                    }
                }
            }
        }
    }
}