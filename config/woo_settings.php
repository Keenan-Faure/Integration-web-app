<?php

//user can only see current settings
//is not allowed to alter any information
//has to contact 'admin' to make changes to the s2s_settings.php file 
//on the server

return array(
    "Woocommerce_Store" =>
    array(
        "store_name" => "s2s.ucc.co.za",
        "consumer_key" => "ck_95cdf3d8b96beb682eaa8fdac18d9c0c197751e5",
        "consumer_secret" => "cs_63105a5c9d86c4572c4542c1233f5597783b12bb"),

    "Woocommerce_Settings" =>
    array(
        "woo_add_products" => "true",
        "woo_delete_products" => "false",
        "woo_product_map" => 
        '{}'),
    "Woocommerce_PostMaps" =>
    array(
        "updateCustomer" => 
        '{
            "first_name": "James",
            "billing": 
            {
                "first_name": "James"
            },
            "shipping": 
            {
                "first_name": "James"
            }
        }',
        "updateProduct" => 
        '{

         }',
        "updateOrder" => 
        '{

         }'
    )
);

?>