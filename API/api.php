<?php
    session_start();
    //check if the api-credentials have been set...
    if(isset($_SESSION['apicredentials']) && $_SESSION['apicredentials']->active == true)
    {
        //saves to log
        $variable = new \stdClass();
        $variable->message = "Successfully connected to connect to API: " . $_SESSION['apicredentials']->credentials->apiUsername . ":" . $_SESSION['apicredentials']->credentials->apiPassword;
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        array_push($_SESSION['log'], $variable);
        
        
        $url = parse_url($_SERVER['REQUEST_URI'])['path'];
        print_r($url);

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

    //define __call() which executes whenever you try to run a function that does not exist.

    //if they have, then display all endpoints defined in a class/database maybe

    //else rediret user to index.php (api login)

    //fix tables, it has to check if that table exists, if it doesn't it should advise the person to query show tables;

    //scan through the sent URL, if it is what we expect then we can run a function based on that url. We have to create
    //Another class/file to define these functions, thinking of using Controller to store them in.

    //change the way the login for the api works so that it checks the token and secret instead of the database uname and psw

?>