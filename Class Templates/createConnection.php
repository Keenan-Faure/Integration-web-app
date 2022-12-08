<?php
namespace Connection;
class Connection
{
    //creates a connection to the Database using the credentials provided
    //to run queries
    function createConnection($username, $password, $host, $db)
    {
        $conn = null;
        try
        {
            $conn = new \mysqli($host, $username, $password, $db);
        }
        catch(\Exception $error)
        {
            $variable = new \stdClass();
            $variable->active = false;
            $variable->message = $error->getMessage();
            $variable->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
            return $variable;
        }

        //connection successful
        //creates a stdClass representation of the connection details
        $this->connection = new \stdClass();
        $this->connection->active = true;
        $this->connection->credentials = new \stdClass();

        $this->connection->credentials->username = $username;
        $this->connection->credentials->password = $password;
        $this->connection->credentials->host = $host; //harcoded to localhost
        $this->connection->credentials->dbname = $db;
        $this->connection->rawValue = $conn;
        $this->connection->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $this->connection->token = $this->createToken($username . $password);
        
        if(!isset($_SESSION['connection']))
        {
            $_SESSION['connection'] = $this->connection;
        }

        $serverConnection = new \stdClass();
        $serverConnection->connection = true;
        $serverConnection->message = 'Connected to MySql server on ' . $host . ' successful';

        return $this->connection;
    }

    //checks if the user entered at the login page is valid
    //and if it exists in the usertable defined in the database
    function connectUser($_config, $client_user, $client_pass)
    {
        $query = 'SELECT * FROM Userz WHERE Username = "' . $client_user . '"';
        $results = $this->preQuery($_config, $query, 'object');
        if($results->result == null)
        {
            //then the user does not exist at all, has to be created.
            $message = 'The Username "' . $client_user . '" does not exist.';
            $solution = 'Kindly contact your admin or register your account';
            $this->createHtmlMessages('', $message, $solution, '../auth/register', 'warn');
            exit();
        }
        else
        {
            //create new query and check if the password corresponds to the username
            $query = 'SELECT * FROM Userz Where Username = "' . $client_user . '" && Password = "' . $client_pass . '"';
            $results = $this->preQuery($_config, $query, 'object');
            if($results->result != null)
            {
                if($results->result[0]->Active == null || $results->result[0]->Active == 'true')
                {
                    $message = 'Successfully connected to server with Username "' . $client_user . '"';
                    //creates session variable containing connection details
                    //creates a stdClass representation of the connection details
                    $this->connection = new \stdClass();
                    $this->connection->active = true;
                    $this->connection->credentials = new \stdClass();

                    $this->connection->credentials->username = $client_user;
                    $this->connection->credentials->password = '_';
                    $this->connection->credentials->host = $_config['host']; //harcoded to localhost
                    $this->connection->credentials->dbname = $_config['dbName'];
                    $this->connection->time = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                    $this->connection->token = $this->createToken($client_user . $client_pass);

                    //stores it inside a session
                    $_SESSION['clientConn'] = $this->connection;

                    //stores connection credentials in session variable
                    $this->createConnection($_config['dbUser'], $_config['dbPass'], $_config['host'], $_config['dbName']);

                    $variable = new \stdClass();
                    $variable->connection = true; 
                    $variable->message = $message;
                    return $variable;
                }
                else
                {
                    $message = 'This account with Username "' . $client_user . '" is currently Inactive';
                    $solution = "Please wait until you are redirected";
                    $this->createHtmlMessages('', $message, $solution, 'login', 'info');

                    $variable = new \stdClass();
                    $variable->connection = false; 
                    $variable->message = $message;

                    return $variable;
                }
            }
            else
            {
                $message = 'Incorrect credentials entered with Username: "' . $client_user . '"';
                $solution = "Please try again";
                $this->createHtmlMessages('', $message, $solution, 'login', 'warn');

                $variable = new \stdClass();
                $variable->connection = false; 
                $variable->message = $message;
                return $variable;
            }
        }
    }

    //creates html markup which uses the same
    //format but has different messages relative to the $error
    //takes three parameters
    // - The error message
    // - The best solution that the user can take
    // - and the link that redirects the user
    function createHtmlMessages($extension = '', $message = 'No msg specified', $solution = 'No Solution provided', $link = '', $type = 'warn')
    {
        if($extension == null)
        {
            $extension = '.php';
        }
        echo("
            <html>
                <head>
                    <link rel='icon' type=image/x-icon' href='../Images/logo.png'/>
                    <link rel='stylesheet' href='../../Styles/login.css'>
                </head>
                <body>
                    <div class='background-cover'>
                    </div>
                    <div class='background-reg'>
                        <div class='cover' id='$type'>
                        </div>
                        <div class='con'>
                            <h2>Message</h2>          
                            <p>$message</p>
                            <hr>
                            <p>$solution</p>
                            <div class='cen'>
                                <a class='btn' href='../../$link" . $extension . "'>Redirect</a>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        ");
    }
    function createJsonMessages($message, $solution, $link, $type, $prefix = 'html')
    {
        echo("
            <html>
                <head>
                    <link rel='icon' type=image/x-icon' href='../Images/logo.png'/>
                    <link rel='stylesheet' href='../../Styles/login.css'>
                </head>
                <body>
                    <div class='background-cover'>
                    </div>
                    <div class='background-reg'>
                        <div class='cover' id='$type'>
                        </div>
                        <div class='con'>
                            <h2>Message</h2>          
                            <p>$message</p>
                            <hr>
                            <pre class='jsonText'>$solution</pre>
                            <div class='cen'>
                                <a class='btn' href='../$link.$prefix'>Redirect</a>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        ");
    }

    //pre-conection queries
    //made with the datafound in the config php file

    function preQuery($_config, $query, $key)
    {
        try
        {
            $host = $_config['host'];
            $username = $_config['dbUser'];
            $password = $_config['dbPass'];
            $db = $_config['dbName'];
            try
            {
                $conn = new \mysqli($host, $username, $password, $db);
            }
            catch(\Exception $error)
            {
                $conn = new \stdClass();
                $conn->connection = false;
                $conn->message = $error->getMessage();
                return $conn;
            }
            if($key == 'array')
            {
                return $this->converterArray($conn, $query);
            }
            return $this->converterObject($conn, $query);
        }
        catch(\Exception $error)
        {
            $variable = new \stdClass();
            $variable->message = $error->getMessage();
            print_r(json_encode($variable));
            exit();
        }
    }

    //-- ONLY USED BY API (legacy) --//
    //connects the client to the mysql server
    //using the username and password found 
    //in the config.php file
    //this is hardcoded to:
    //username = root
    //password = ''
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
            return 0;
        }
        else
        {
            $amount = $result->result[0]->total;
            $pages = $amount / 10;
            return round($pages);
        }
    }

    //returns the query params as a php array
    //using the URL provided
    //has to be entire URL
    function queryParams($url)
    {
        $partitions = parse_url($url);
        if(isset($partitions['query']))
        {
            $queryParams = array();
            parse_str($partitions['query'], $queryParams);
            if(isset($queryParams['page']))
            {
                return $queryParams;
            }
            if(isset($queryParams['type']))
            {
                return $queryParams;
            }
            if(isset($queryParams['logout']))
            {
                return $queryParams;
            }
            if(isset($queryParams['q']))
            {
                return $queryParams;
            }
            if(isset($queryParams['endpoint']))
            {
                return $queryParams;
            }
            else
            {
                return 1;
            }
        }
        else
        {
            return false;
        }
    }

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
                $variable->raw_query = str_replace(PHP_EOL, '', $query);;
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
                            $variable->query = str_replace(PHP_EOL, '', $query);;
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
                        $variable->query = str_replace(PHP_EOL, '', $query);
                        $variable->query_time = $duration;
                    }
                }
                else
                {
                    $variable = new \stdClass();
                    $variable->result = new \stdClass();
                    $variable->result = null;
                    $variable->query = str_replace(PHP_EOL, '', $query);;
                    $variable->query_time = $duration;
                }
            }
            catch(\Exception $error)
            {
                $variable = new \stdClass();
                $variable->error = $error->getMessage();
                $variable->query = str_replace(PHP_EOL, '', $query);
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

    //createToken
    function createToken($credentials)
    {
        $token = rand(1000,9999); //must be a 4 digit number
        $token = $token . '-' .  base64_encode($credentials);
        return $token;
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
    
    //creates the stdClass required when storing data 
    //in the logs session - some are inserted into the database?
    //where head -> message head (topic)
    //body -> main message 
    //type -> information, warning etc
    function addLogs($head, $body, $_time, $_type, $saved)
    {
        $_config = include("../../config/config.php");
        if(!isset($_SESSION))
        {
            session_start();
        }
        $variable = new \stdClass();
        $variable->head = $head;
        $variable->body = $body;
        $variable->time = $_time;
        $variable->type = $_type;

        array_push($_SESSION['log'], $variable);
        if($saved == true)
        {
            $query = 'INSERT INTO Logs(Head, Body, T_ime , T_ype)VALUES("' . $head . '","' . $body . '","' . $_time . '","' . $_type . '")';
            $this->preQuery($_config, $query, 'object');
        }
    }

    //sets the settings in the session
    function setSettings($_settings)
    {
        $variable = new \stdClass();
        foreach($_settings as $x => $value)
        {
            $variable->$x = new \stdClass;
            if(sizeof($value) > 0)
            {
                foreach($value as $y => $subValue)
                {
                    $variable->$x->$y = $subValue;
                }
            }
        }
        return $variable;
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