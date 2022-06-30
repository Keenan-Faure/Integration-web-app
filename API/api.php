<?php
    session_start();
    include("Controller/API/BaseController.php");
    header("Content-Type: application/json");
    use controller\Controller as control;

    //check if the api-credentials have been set...
    if(isset($_SESSION['apicredentials']) && $_SESSION['apicredentials']->active == true)
    {
        //saves to log
        $variable = new \stdClass();
        $variable->message = "Successfully connected to API with: " . $_SESSION['apicredentials']->credentials->token . ": secret_" . $_SESSION['apicredentials']->credentials->secret;
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        array_push($_SESSION['log'], $variable);
        
        $url = parse_url($_SERVER['REQUEST_URI'])['path'];

        $url = explode('/', $url);
        //only if the 5th segment of the url is defined and populated
        //then run a function on it.
        if(isset($url[4]))
        {
            $segment = $url[4];
            print_r($segment);
        }

        //else display all url functions (endpoints)
        else
        {
            $variable = new control();
            echo(json_encode($variable->endpoints($_SESSION['serverconnection']->active)));
        }
    }
    else
    {
        $variable = new \stdClass();
        $variable->error = "Failed to connect to API";
        $variable->message = "Either no credentials were entered, or incorrect matches were given";
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        array_push($_SESSION['log'], $variable);
        echo(json_encode($variable));
        header('Refresh:3,url=index.php');
}


    //if they have, then display all endpoints defined in a class/database maybe

    //else rediret user to index.php (api login)

    //fix tables, it has to check if that table exists, if it doesn't it should advise the person to query show tables;

    //scan through the sent URL, if it is what we expect then we can run a function based on that url. We have to create
    //Another class/file to define these functions, thinking of using Controller to store them in.

    //When setting the table, we need to add a check to confirm if the table has all basic product information, or if one has to be created. We should ask.
    /*
        SKU, Title, Description, product code, active field (when if), category, product-type, 
        Brand, options (name, value), variant code, weight, barcode, price, quantity.

    */
    

?>