<?php

namespace Connection;
session_start();
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
            $_SESSION['connection'] = false;
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
        $this->connection->time = $_SERVER['REQUEST_TIME'];
        $_SESSION['connection'] = $this->connection;
        return $this->connection;
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