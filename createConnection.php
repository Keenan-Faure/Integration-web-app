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
        $this->connection->rawValue = $conn;
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
        $this->connection->rawValue = $serverConnections;
        $_SESSION['serverconnection'] = $this->connection;
        
        $serverConnection = new \stdClass();
        $serverConnection->connection = true;
        $serverConnection->rawValue = $serverConnections;
        $serverConnection->message = 'Connected to MySql server on localhost successful';

        return $serverConnection;
    }
    
    //converts mysqli object to php object
    function converterObject($rawConnection, $query)
    {
        $resultArray = array();
        $output = array();
        $duration = 0;
        $variable = null;
        $starttime = microtime(true);
        if($result = mysqli_query($rawConnection, $query))
        {
            $endtime = microtime(true);
            $duration = $endtime - $starttime; //calculates total time taken
            $array = array();
            while($row = $result->fetch_object())
            {
                $array = $row;
                array_push($resultArray, $array);
            }
            for($i = 0; $i < sizeof($resultArray); ++$i)
            {
                array_push($output, $resultArray[$i]);
            }    
        }
        if(sizeof($output) < 1)
        {
            $variable = new \stdClass();
            $variable->query = $query;
            $variable->query_time = $duration;
            $variable->result = '';
        }
        else
        {
            $variable = new \stdClass();
            $variable->query = $query;
            $variable->query_time = $duration;
            
            for($i = 0; $i < sizeof($output); ++$i)
            {
                print_r($output[$i]);
            }
        }
        
        return $variable;
    }
    function converterArray($rawConnection, $query)
    {
        $resultArray = array();
        $output = array();
        if($result = mysqli_query($rawConnection, $query))
        {
            $array = array();
            while($row = $result->fetch_object())
            {
                $array = $row;
                array_push($resultArray, $array);
            }
            for($i = 0; $i < sizeof($resultArray); ++$i)
            {
                array_push($output, $resultArray[$i]->Database);
            }    
        }
        return $output;
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