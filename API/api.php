<?php
    session_start();
    //check if the api-credentials have been set...
    if(isset($_SESSION['apicredentials']) && $_SESSION['apicredentials']->active == true)
    {
        echo(json_encode($_SESSION));
    }
    //if they have, then display all endpoints defined in a class/database maybe

    //else rediret user to index.php (api login)

    //fix tables, it has to check if that table exists, if it doesn't it should advise the person to query show tables;

?>