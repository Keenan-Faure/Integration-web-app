<?php

//user can only see current settings
//is not allowed to alter any information
//has to contact 'admin' to make changes to the settings.php file 
//on the server

return array(

    //S2S User credentials
    's2s_user' => 'keenan.faure',
    's2s_password' => 'Re_Ghoul',

    //S2S settings
    's2s_addProducts' => 'true',
    's2s_deleteProducts' => 'true',
    's2s_productMap' => '{}',
    
    //App settings
    'app_deleteProducts' => 'false',
    'app_addProducts' => 'true', 
    'app_enableSelfQuery' => 'true', 
    'app_enableProductPush' => 'true',
    
    //API settings
    'api_enabled' => 'true'
);

?>