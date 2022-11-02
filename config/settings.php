<?php

//user can only see current settings
//is not allowed to alter any information
//has to contact 'admin' to make changes to the settings.php file 
//on the server

return array(
    'Stock2Shop_Credentials' =>
    array(
        's2s_user' => 'keenan.faure',
        's2s_password' => 'Re_Ghoul'),

    'S2S_settings' =>
    array(
        's2s_add_products' => 'true',
        's2s_delete_products' => 'true',
        's2s_product_map' => '{}'),
    
    'App_settings' =>
    array(
        'app_delete_products' => 'false',
        'app_add_products' => 'true', 
        'app_enable_self_query' => 'true', 
        'app_enable_product_push' => 'true'),
    
    'API_settings' =>
    array(
        'api_enabled' => 'true')
);

?>