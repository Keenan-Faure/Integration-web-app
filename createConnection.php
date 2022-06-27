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
    function connectAPI($token, $secret)
    {
        if(isset($_SESSION['apicredentials']))
        {
            if($_SESSION['apicredentials']->credentials->token == $token)
            {
                if($_SESSION['apicredentials']->credentials->secret == $secret)
                {
                    $variable = new \stdClass();
                    $variable->active = true;
                    $variable->message = 'Valid API credentials';
                    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

                    return $variable;
                }
                else
                {
                    $variable = new \stdClass();
                    $variable->active = false;
                    $variable->message = 'Invalid API secret';
                    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                }
            }
            else
            {
                $variable = new \stdClass();
                $variable->active = false;
                $variable->message = 'Invalid API token';
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->active = false;
            $variable->message = 'No API credentials detected in database, contact admin!';
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        }
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
        if($query === '')
        {
            $variable = new \stdClass();
            $variable->error = 'Uncaught ValueError: mysqli_query(), ($query) cannot be empty';
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        }
        else
        {
            $resultArray = array();
            $output = array();
            $duration = 0;
            $variable = null;
            $starttime = microtime(true);
            try
            {
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
                    $variable = new \stdClass();
                    $variable->result = $output;
                    $variable->query = $query;
                    $variable->query_time = $duration;
                }
                else
                {
                    $variable = new \stdClass();
                    $variable->result = new \stdClass();
                    $variable->result = null;
                    $variable->query = $query;
                    $variable->query_time = $duration;
                }
            }
            catch(\Exception $error)
            {
                $variable = new \stdClass();
                $variable->error = $error->getMessage();
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            }
        }
        
        return $variable;
    }
    function converterArray($rawConnection, $query, $key)
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
                array_push($output, $resultArray[$i]->$key);
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