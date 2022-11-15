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
        "woo_use_product_map" => "true", //true, false
        "woo_add_products" => "true", //true, false
        "woo_product_status" => "publish", //can be publish, draft
        "woo_delete_products" => "false", //true, false
        "woo_product_map" => 
        '{
            "title": "$product->Title",
            "type": "$product->Type",
            "status": "$_wooSettings->Woocommerce_Settings->woo_product_status",
            "managing_stock": false,
            "description": "$product->Description",
            "short_description": "",
            "attributes": 
            [
                {
                    "name": "Brand",
                    "slug": "brand",
                    "position": 1,
                    "visible": true,
                    "variation": false,
                    "options": 
                    [
                        "$product->Brand"
                    ]
                },
                {
                    "name": "Product Type",
                    "slug": "product-type",
                    "position": 2,
                    "visible": true,
                    "variation": false,
                    "options": 
                    [
                        "$product->Meta_1"
                    ]
                },
                {
                    "name": "Version Released",
                    "slug": "product-version",
                    "position": 3,
                    "visible": true,
                    "variation": false,
                    "options": 
                    [
                        "$product->Meta_3"
                    ]
                }
            ],
            "variations": 
            [{
                "sku": "$product->SKU",
                "regular_price": "$product->ComparePrice",
                "sale_price": "$product->SellingPrice",
                "stock_quantity": "$product->CapeTown_Warehouse",
                "weight": "$product->Weight"
            }]
        }'
    )
);

?>