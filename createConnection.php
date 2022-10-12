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
                    return $variable;
                }
            }
            else
            {
                $variable = new \stdClass();
                $variable->active = false;
                $variable->message = 'Invalid API token';
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                return $variable;
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->active = false;
            $variable->message = 'No API credentials detected in database, contact admin!';
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            return $variable;
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
    //function for pagination
    //1.) Gets the total number of products in the Database
    //2.) Divided it by 10 (10 products per page) 
    //3.) Then returns that number which will be used
    //    To create the amount of <a> tags
    //type can be 'Inventory' or 'Client'
    function pagination($rawConnection, $type)
    {
        $query = "SELECT COUNT(*) AS total FROM " . $type;
        $result = $this->converterObject($rawConnection, $query);
        if($result->result[0]->total < 11)
        {
            return 1;
        }
        else
        {
            $amount = $result->result[0]->total;
            $pages = $amount / 10;
            return round($pages);
        }
    }

    //uses pagination function to 

    //converts mysqli object to php object
    function converterObject($rawConnection, $query, $parameter=null)
    {
        if($query === '')
        {
            $variable = new \stdClass();
            $variable->error = 'Uncaught ValueError: mysqli_query(), ($query) cannot be empty';
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        }
        else
        {
            if(str_contains(strtolower($query),'insert into') && $parameter === 'selfquery')
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->raw_query = $query;
                $variable->message = "Not allowed via Custom Query";

                return $variable;
            }
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
                    if(is_bool($result))
                    {
                        if($result)
                        {
                            $variable = new \stdClass();
                            $variable->result = true;
                            $variable->query = $query;
                            $variable->duration = $duration;
                        }
                    }
                    else
                    {
                        while($row = $result->fetch_object())
                        {
                            if(isset($row->Description))
                            {
                                $var = htmlspecialchars(stripslashes(str_replace('"', "'", $row->Description)));
                                $row->Description = $var;
                            }
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
                $variable->query = $query;
                $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            }
        }
        
        return $variable;
    }

    //function to return the databases or tables inside the database 
    function converterArray($rawConnection, $query)
    {
        $output = array();
        if($result = mysqli_query($rawConnection, $query))
        {
            while($row = $result->fetch_object())
            {
                    
                //converts it into a php array
                $row = json_decode(json_encode($row), true);
                //gets the first element of the associative array
                $row = array_shift($row);
                
                array_push($output, $row);    
            }
        }
        return $output;
    }

    //accessor methods
    function getUsername()
    {
        return $this->username;
    }

    function getPassword()
    {
        return $this->password;
    }

    function getHost()
    {
        return $this->host;
    }

    function getDbname()
    {
       return $this->dbName;
    }
}

?>