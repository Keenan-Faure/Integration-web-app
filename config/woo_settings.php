<?php

//user can only see current settings
//is not allowed to alter any information
//has to contact 'admin' to make changes to the s2s_settings.php file 
//on the server

return array(
    "Woocommerce_Store" =>
    array(
        "store_name" => "woocommercestore.co.za",
        "consumer_key" => "ck_0908",
        "consumer_secret" => "cs_0908"),
    "Woocommerce_Settings" =>
    array(
        "woo_use_product_map" => "true", //true, false
        "woo_add_products" => "true", //true, false
        "woo_product_status" => "publish", //can be publish, draft
        "woo_delete_products" => "false", //true, false
        "woo_product_map" => 
        '{
            "title": "$product->Title",
            "status": "$_wooSettings->Woocommerce_Settings->woo_product_status",
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
