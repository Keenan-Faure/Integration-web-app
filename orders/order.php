<?php

    include("../Class Templates/createConnection.php");
    include("../Class Templates/utility.php");
    $_woo_settings = include("../config/woo_settings.php");

    use Connection\Connection as connect;
    use utils\Utility as util;

    $conn = new connect();
    $_woo_settings = $conn->setSettings($_woo_settings);

    //gets all order headers from URL
        //verify the headers - if the right store
    //get request content from URL

    //write data to database
        //if order id already exists then update existing order
        //else if it does not exist then we create fresh order
    //

    //gets all order headers from URL
    $headers = json_decode(json_encode(getallheaders()), FALSE);
    print_r($headers);
    //verify data sent using headers
    

    // $util = new util();
    // $util->writeToFile('output', 'w', ($headers));
    // $util->writeToFile('output1', 'w', ($webhook));

?>