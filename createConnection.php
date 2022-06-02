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
            die("Connection failed: " . $conn->connect_error);
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
        $conn = new \mysqli($host, $username, $password);
        if($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->connection = new \stdClass();
        $this->connection->active = true;
        $this->connection->credentials = new \stdClass();

        $this->connection->credentials->username = $username;
        $this->connection->credentials->password = '*******';
        $this->connection->credentials->host = 'localhost'; //harcoded to localhost
        $this->connection->token = rand();
        $this->connection->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $this->connection->rawvalue = $conn;
        $_SESSION['serverconnection'] = $this->connection;
        return $conn;
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

    //mutator methods
    //cannot change userdefined credentials!!

}

?>