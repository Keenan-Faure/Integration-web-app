<?php

//user can only see current settings
//is not allowed to alter any information
//has to contact 'admin' to make changes to the s2s_settings.php file 
//on the server

return array(
    "App_settings" =>
    array(
        "app_delete_products" => "false",
        "app_add_products" => "true", 
        "app_enable_self_query" => "true", 
        "app_enable_product_push" => "true"),
    
    "API_settings" =>
    array(
        "api_enabled" => "true",
        "api_database" => "dbClover")
);

?>
