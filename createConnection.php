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

    function createConnection($username=null, $password='', $host='localhost', $dbName='xyz987')
    {
        $conn = null;
        try
        {
            $conn = new \mysqli($host, $username, $password, $dbName);
        }
        catch(\Exception $error)
        {
            $variable = new \stdClass();
            $variable->active = false;
            $variable->message = $error->getMessage();
            $variable->token = rand();
            $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            return $variable;
        }

        // connection successful
        $this->connection = new \stdClass();
        $this->connection->active = true;
        $this->connection->credentials = new \stdClass();

        $this->connection->credentials->username = $username;
        $this->connection->credentials->password = $password;
        $this->connection->credentials->host = 'localhost'; //harcoded to localhost
        $this->connection->credentials->dbname = $dbName;
        $this->connection->token = rand();
        $this->connection->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $_SESSION['connection'] = $this->connection;
        return $this->connection;
    }
    function connectServer($username='null', $password='', $host='localhost')
    {
        $serverConnections = null;
        try
        {
            $serverConnections = new \mysqli($host, $username, $password);
        }
        catch(\Exception $error)
        {
            $variable = new \stdClass();
            $variable->connection = false;
            $variable->message = $error->getMessage();
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
        $serverConnection->rawValue = $serverConnections;
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