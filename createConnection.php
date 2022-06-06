<?php

namespace Connection;
class Connection
{
    private $username;
    private $password;
    public $timestamp;
    private $host;
    private $dbName;

    public $connection;

    function createConnection($username='null', $password='', $host='localhost', $dbName='xyz987')
    {
        $conn = new \mysqli($host, $username, $password, $dbName);
        if($conn->connect_error)
        {
            $result = new \stdClass();
            $result->active=false;
            $result->message='Error has occurred when trying to connect to the database';
            $result->token = rand();
            $result->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            header("Refresh:2,url=serverData.php");
        }
        $this->connection = new \stdClass();
        $this->connection->active = true;
        $this->connection->credentials = new \stdClass();

        $this->connection->credentials->username = $username;
        $this->connection->credentials->password = '*******';
        $this->connection->credentials->host = 'localhost'; //harcoded to localhost
        $this->connection->credentials->dbname = $dbName;
        $this->connection->token = rand();
        $this->connection->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $this->connection->rawvalue = $conn;
        $_SESSION['connection'] = $this->connection;
        return $this->connection;
    }
    function connectServer($username='null', $password='', $host='localhost')
    {
        $serverConnection = null;
        try
        {
            $serverConnection = new \mysqli($host, $username, $password);
        }
        catch(\Exception $error)
        {
            $variable = new \stdClass();
            $variable->connection = false;
            $variable->message = 'Access denied for user ' . $username . '@localhost with password ' . $password;
            return $variable;
        }
       
        // connection successful
        $this->connection = new \stdClass();
        $this->connection->active = true;
        $this->connection->credentials = new \stdClass();

        $this->connection->credentials->username = $username;
        $this->connection->credentials->password = '*******';
        $this->connection->credentials->host = 'localhost'; //harcoded to localhost
        $this->connection->token = rand();
        $this->connection->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $_SESSION['serverconnection'] = $this->connection;
        
        $serverConnection = new \stdClass();
        $serverConnection->connection = true;
        $serverConnection->message = 'Connected to MySql server on localhost successful';

        return $serverConnection;
    }

    //accessor methods
    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getDbname()
    {
       return $this->dbName; 
    }
}

?>