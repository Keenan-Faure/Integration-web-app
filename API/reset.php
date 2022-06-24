<?php
    session_start();
    if(isset($_SESSION['apicredentials']))
    {
        if(isset($_SESSION['serverconnection']))
        {
            if($_SESSION['serverconnection']->active === true && $_SESSION['credentials']->active === true)
            {
                $variable = new \stdClass();
                $variable->apiCredentials = new \stdClass();
                $variable->apiCredentials->token = $_SESSION['apicredentials']->credentials->token;
                $variable->apiCredentials->secret = $_SESSION['apicredentials']->credentials->secret;
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                echo(json_encode($variable));
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->error = "No connection to server found in current session";
            $variable->message = "Try to relog";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            echo(json_encode($variable));
            header('Refresh:2,url=../login');
        }
    }
    else
    {
        if(isset($_SESSION['serverconnection']))
        {
            if($_SESSION['serverconnection']->active === true && $_SESSION['credentials']->active === true)
            {
                $token = 'token_' . bin2hex(openssl_random_pseudo_bytes(10));
                $secret = 'secret_' . bin2hex(openssl_random_pseudo_bytes(10));

                $variable = new \stdClass();
                $variable->message = 'API details';
                $variable->credentials = new \stdClass();
                $variable->credentials->token = $token;
                $variable->credentials->secret = $secret;

                $_SESSION['apicredentials'] = $variable;

                $variable = new \stdClass();
                $variable->result = true;
                $variable->message = 'API credentials has been reset, 10s until redirect';
                $variable->apiDetails = new \stdClass();
                $variable->apiDetails->token = $token;
                $variable->apiDetails->secret = $secret;
                $variable->timeStamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                echo(json_encode($variable));
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->error = "No connection to server found in current session";
            $variable->message = "Try to relog";
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            echo(json_encode($variable));
            header('Refresh:2,url=index.php');
        }
    }

?>