<?php

namespace orders;

Class Orders
{
    /**
     * Adds the order to the database
     */
    function addOrder(\stdClass $orderBody, \Connection\Connection $connection, \stdClass $_settings)
    {
        $query = "INSERT INTO Orders
        (
            ID,
            OrderStatus,
            currency,
            total,
            subTotal,
            totalTax, 
            totalShipping,
            shippingTax,
            discount,
            paymentDetails,
            billingAddress,
            shippingAddress,
            note,
            lineItems,
            shippingLines,
            taxLines,
            customer,
            wooOrder,
            createdDate,
            modifiedDate,
            completedDate
        )
        VALUES 
        (
            '" . $orderBody->order->order_number . "','" .
            $orderBody->order->status . "','" .
            $orderBody->order->currency . "','" .
            $orderBody->order->total . "','" .
            $orderBody->order->subtotal . "','" .
            $orderBody->order->total_tax . "','" .
            $orderBody->order->total_shipping . "','" .
            $orderBody->order->shipping_tax . "','" .
            $orderBody->order->total_discount . "','" .
            serialize($orderBody->order->payment_details) . "','" .
            serialize($orderBody->order->billing_address) . "','" .
            serialize($orderBody->order->shipping_address) . "','" .
            (str_replace('"', "", $orderBody->order->note)) . "','" .
            serialize($orderBody->order->line_items) . "','" .
            serialize($orderBody->order->shipping_lines) . "','" .
            serialize($orderBody->order->tax_lines) . "','" .
            serialize($orderBody->order->customer) . "','" . 
            serialize($orderBody) . "','" . 

            ($orderBody->order->created_at) . "','" . 
            ($orderBody->order->updated_at) . "','" . 
            $orderBody->order->completed_at . "');"
        ;

        $rawConnection = $connection->createConnection($_settings->dbUser, $_settings->dbPass, 'localhost', $_settings->dbName)->rawValue;
        $connection->converterObject($rawConnection, $query, $_settings->dbName);  
    }

    /**
     * Updates an existing order
     */
    function updateOrder(\stdClass $orderBody, \Connection\Connection $connection, \stdClass $_settings)
    {
        //serialize values before updating
        $orderBody->order->customer = serialize($orderBody->order->customer);
        $orderBody->order->tax_lines = serialize($orderBody->order->tax_lines);
        $orderBody->order->shipping_lines = serialize($orderBody->order->shipping_lines);
        $orderBody->order->line_items = serialize($orderBody->order->line_items);
        $orderBody->order->note = (str_replace('"', "" , $orderBody->order->note));
        $orderBody->order->shipping_address = serialize($orderBody->order->shipping_address);
        $orderBody->order->billing_address = serialize($orderBody->order->billing_address);
        $orderBody->order->payment_details = serialize($orderBody->order->payment_details);
        $orderWoo = serialize($orderBody->order);

        $query = "UPDATE Orders

        SET 
            ID = '{$orderBody->order->order_number}',
            OrderStatus = '{$orderBody->order->status}',
            currency = '{$orderBody->order->currency}',
            total = '{$orderBody->order->total}',
            subTotal = '{$orderBody->order->subtotal}',
            totalTax = '{$orderBody->order->total_tax}',
            totalShipping = '{$orderBody->order->total_shipping}',
            shippingTax = '{$orderBody->order->shipping_tax}',
            discount = '{$orderBody->order->total_discount}',
            paymentDetails = '{$orderBody->order->payment_details}',
            billingAddress = '{$orderBody->order->billing_address}',
            shippingAddress = '{$orderBody->order->shipping_address}',
            note = '{$orderBody->order->note}',
            lineItems = '{$orderBody->order->line_items}',
            shippingLines = '{$orderBody->order->shipping_lines}',
            taxLines = '{$orderBody->order->tax_lines}',
            customer = '{$orderBody->order->customer}',
            wooOrder = '{$orderWoo}',
            createdDate = '{$orderBody->order->created_at}',
            modifiedDate = '{$orderBody->order->updated_at}',
            completedDate = '{$orderBody->order->completed_at}'
            
        WHERE ID = '{$orderBody->order->order_number}'"
        ;

        $rawConnection = $connection->createConnection($_settings->dbUser, $_settings->dbPass, 'localhost', $_settings->dbName)->rawValue;
        $connection->converterObject($rawConnection, $query, $_settings->dbName);  
    }

    /**
     * Checks if the order exists in the database already using `order_id`
     * @return bool
     */
    function checkOrderExist(string $order_id, \Connection\Connection $connection, \stdClass $_settings)
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

    /**
     * Verifies the webhook using the headers received
     * @return boolean
     */
    function verifyWebhook(\stdClass $requestBody, \stdClass $headers, \stdClass $_wooSettings)
    {
        if(isset($headers->{'X-Wc-Webhook-Resource'}) && isset($headers->{'X-Wc-Webhook-Source'}))
        {
            if($headers->{'X-Wc-Webhook-Resource'} == 'order')
            {
                if($headers->{'X-Wc-Webhook-Source'} == ('https://' . $_wooSettings->Woocommerce_Store->store_name . '/'))
                {
                    if($_wooSettings->Woocommerce_Settings->woo_enable_hmac_decoding == "true")
                    {
                        $signature = base64_encode(hash_hmac('sha256', json_encode($requestBody), $_wooSettings->Woocommerce_Store->webhook_secret, true));
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