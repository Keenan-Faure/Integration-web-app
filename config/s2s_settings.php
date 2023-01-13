<?php

//user can only see current settings
//is not allowed to alter any information
//has to contact 'admin' to make changes to the s2s_settings.php file 
//on the server

return array(
    "Stock2Shop_Credentials" =>
    array(
        "s2s_user" => "username",
        "s2s_password" => "password"),

    "S2S_settings" =>
    array(
        "s2s_add_products" => "true",
        "s2s_delete_products" => "true",
        "s2s_use_product_map" => "true",
        "s2s_product_map" => 
        '{
            "source": 
            {
                "source_id": "$source->id",
                "product_active": "$product->Active",
                "source_product_code": "$product->Group_Code",
                "sync_token": "$source->sync_token",
                "fetch_token": "$source->fetch_token"
            },
            "product": 
            {
                "options": 
                [
                    {
                        "name": "$product->Option_1_Name",
                        "position": "1"
                    },
                    {
                        "name": "$product->Option_2_Name",
                        "position": "2"
                    }
                ],
                "body_html": "$product->Description",
                "collection": "$product->Category",
                "product_type": "$product->Product_Type",
                "tags": null,
                "title": "$product->Title",
                "vendor": "$product->Brand",
                "variants": 
                {
                    "source_variant_code": "$product->Variant_Code",
                    "sku": "$product->SKU",
                    "barcode": "$product->Barcode",
                    "qty": null,
                    "qty_availability": 
                    [
                        {
                        "description": "Warehouse 1",
                        "qty": "$product->CapeTown_Warehouse"
                    }],
                    "price": null,
                    "price_tiers": 
                    [
                        {
                            "tier": "Compare To Price",
                            "price": "$product->ComparePrice"
                        },
                        {
                            "tier": "Selling Price",
                            "price": "$product->SellingPrice"
                        }
                    ],
                    "inventory_management": "false",
                    "grams": "$product->Weight",
                    "option1": "$product->Option_1_Value",
                    "option2": "$product->Option_2_Value"
                },
                "meta": 
                [
                    {
                        "key": "Product Type",
                        "value": "$product->Meta_1"
                    },
                    {
                        "key": "Vision",
                        "value": "$product->Meta_2"
                    },
                    {
                        "key": "Version",
                        "value": "$product->Meta_3"
                    }
                ]
            }
         }',
        ),
    "API_settings" =>
    array(
        "api_enabled" => "true")
);

?>
