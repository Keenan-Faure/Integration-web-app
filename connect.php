<?php
session_start();
include('createConnection.php');
$_config = include('config/config.php');

use Connection\Connection as connect;
if(isset($_POST['uname']) && isset($_POST['psw']))
{
    //uses the token to decide whether 
    //to login or not
    if(isset($_SESSION['connection']->token))
    {
        if($_SESSION['connection']->credentials->username == $_POST['uname'] && $_SESSION['connection']->credentials->password == $_POST['psw'])
        {
            header("Refresh:0, url=endpoints.php");
        }
        else
        {
            //removes all previous data of login
            session_destroy();
            $conn = new connect();
            $result = $conn->connectUser($_config, $_POST['uname'], $_POST['psw']);
            if($result->connection == false)
            {
                if(isset($_SESSION['log']))
                {
                    $conn->addLogs('Connection failed', $result->message, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
                }
                header('Refresh:3,url=login.php');
            }
            else
            {
                unset($_POST['uname']);
                unset($_POST['psw']);
                if(isset($_SESSION['log']))
                {
                    $conn->addLogs('Connection successful', $result->message, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', false);
                }
                header('Refresh:3, url=endpoints.php');
            }
        }
    }
    else
    {
        $conn = new connect();
        $result = $conn->connectUser($_config, $_POST['uname'], $_POST['psw']);
        if($result->connection == false)
        {
            if(isset($_SESSION['log']))
            {
                $conn->addLogs('Connection failed', $result->message, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
            }
            header('Refresh:3,url=login.php');
        }
        else
        {
            unset($_POST['uname']);
            unset($_POST['psw']);
            if(isset($_SESSION['log']))
            {
                $conn->addLogs('Connection successful', $result->message, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', false);
            }
            header('Refresh:3, url=endpoints.php');
        }
    }
}
else if(isset($_POST['runame']) && isset($_POST['rpsw']))
{

    $conn = new connect();

    $query = 'SELECT COUNT(*) as total FROM Users WHERE Username = "' . $_POST['runame'] . '"';
    $result = $conn->preQuery($_config, $query, 'object');
    if($result->result[0]->total > 0)
    {
        $message = 'User ' . $_POST['runame'] . ' already exists in database';
        $solution = 'Click the button below to return to the login page and try again';
        $conn->createHtmlMessages($message, $solution, 'register', 'warn');
        exit();
    }
    else
    {
        $query = 'INSERT INTO Users(
            Active,
            Username,
            Password,
            Email,
            Notes
        )
        VALUES(
            "False", "'
            . $_POST["runame"] . '","'
            . $_POST["rpsw"] . '","'
            . $_POST["mail"] . '","'
            . $_POST["note"] . '"
        )';
        $conn->preQuery($_config, $query, 'object');
    
        //creates html message
        $message = 'User ' . $_POST['runame'] . ' was created successfully';
        $solution = 'Click the button below to return to the login page';
        $conn->createHtmlMessages($message, $solution, 'login', 'info');
        if(isset($_SESSION['log']))
        {
            $conn->addLogs('User creation', 'Please review user: "' . $_POST['runame'] . '" before activation', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', true);
        }
        exit();
    }
}
else
{
    if(isset($_POST['token']) && isset($_POST['secret']))
    {
        $variable = new connect();
        $connection = $variable->connectAPI($_POST['token'], $_POST['secret']);
        if($connection->active == false)
        {
            echo(json_encode($connection));
            header('Refresh:2,url=API/index.php');
        }
        if($connection->active == true)
        {
            $variable = new \stdClass();
            $variable->credentials = new \stdClass();
            $variable->active = true;
            $variable->credentials->token = $_POST['token'];
            $variable->credentials->secret = '*******';
            $_SESSION['apicredentials'] = $variable;
            $_SERVER['PHP_AUTH_USER'] = $_POST['token'];
            $_SERVER['PHP_AUTH_PSW'] = $_POST['secret'];
            header('Refresh:0,url=API/api.php');
        }
        else
        {
            die();
        }
        unset($_POST['token']);
        unset($_POST['secret']);
    }
    else
    {
        if(isset($_SESSION['credentials']) && $_SESSION['serverconnection']->active === true)
        {
            if($_SESSION['serverconnection']->active === true)
            {
                $username = $_SESSION['credentials']->username;
                $password = $_SESSION['credentials']->password;
                $host = $_POST['host'];
                $dbname = $_POST['dbName'];

                $variable = new connect();
                $connection = $variable->createConnection($username, $password, 'localhost', $dbname);
                if($connection->active == false)
                {
                    header('Content-Type: application/json');
                    echo(json_encode($connection));
                    if(isset($_SESSION['log']))
                    {
                        $conn->addLogs('API Connection unsuccessful', 'Username: ' . $username . ' Password: ' . $password, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
                    }
                    die();
                }
                if($_SESSION['connection']->active === true)
                {
                    if(isset($_SESSION['log']))
                    {
                        $conn->addLogs('API Connection successful', 'Username: ' . $username . ' Password: ' . $password, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', false);
                    }
                    header('location: endpoints.php');
                }
            }
        }
        else
        {
            $variable = new \stdClass();
            if(!isset($_SESSION['credentials']))
            {
                $variable->message = "No login details found in current session";
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                header('Content-Type: application/json');
                echo(json_encode($variable));
                if(isset($_SESSION['log']))
                {
                    $conn->addLogs('No Session', 'Attempted to connect but no session was found', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', false);
                }
            }
            else if(!isset($_SESSION['serverconnection']))
            {
                $variable->message = "No connection to database found in current session";
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                header('Content-Type: application/json');
                echo(json_encode($variable));
                if(isset($_SESSION['log']))
                {
                    $conn->addLogs('No Session', 'Attempted to connect but no session was found', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', false);
                }    
            }
        }
    }

}
?>