<?php 
    session_start();
    include("createConnection.php");
    use Connection\Connection as connect;
    
    
    if(isset($_SESSION['credentials']) && $_SESSION['credentials']->active == true)
    {
        $connection = new connect();
        $rawConnection = $connection->connectServer($_SESSION['credentials']->username, $_SESSION['credentials']->password)->rawValue;
        //creates query
        $query = 'show DATABASES';
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
            //converts it to a PHP object
            for($i = 0; $i < sizeof($resultArray); ++$i)
            {
                array_push($output, $resultArray[$i]->Database);
            }
            
        }

        

    }
    else
    {
        //the user isnt logged in, display mess
    }
    
    
    //if connected get and then show databases
    //if not connected, try to make a header that refreshes the page once the user logins to the database, then we run the program again to check.
    //finally we use the script 'scripts.js' to display the databases once the user hovers over the dbName input tag.
?>

<html>
    <head>
        <link rel='stylesheet' href='Styles/serverData.css'>
    </head>
    <body>
        <div class='backgroundtwo'>
        <h1>Create Connection to Database</h1>
            <div class='line'></div>
            <div class='next2'>
            </div>
            <div class='nextBtn2'>❮</div>
            <div class="modalContainer">
                <form method='post' action='connect.php' target='endpoints.php'>
                    <input type='text' name='host' placeholder='Localhost' readonly>
                    <br><br>
                    <input type='text' autocomplete="off" class='show' name='dbName' placeholder='Enter Database' required>
                    <br><br>
                    <input class='buttonother' type='submit'>
                </form>
            </div>
        </div>
        <div class = 'background'>
        <div class = 'background-cover'>
            <h1 id='header1'>Check Connection</h1>
            <div class='line' id='line'></div>
            <div class='next' onclick=swap()>
            </div>
            <div class='nextBtn'>❯</div>
            <div class="modalContainer">
                <form method='post' action='output.php' target='_blank'>
                    <input type='text' name='host' placeholder='Localhost' id='f3' readonly>
                    <br><br>
                    <input type='text' autocomplete="off" class='show' name='dbName' placeholder='Enter Database' id='f4' required>
                    <br><br>
                    <input class = 'button' type='submit' id='f5'>
                </form>
                <form action='output.php'>
                    <?php $_SESSION['clearCache'] = true;?>
                    <button class = 'button buttonclear' id='f6'>Clear Session</button>
                </form>
                <div class='log' id='f7'>
                    <h2 style='color: red'>Log</h2>
                    <?php    

                        class server
                        {
                            public $timestamp;
                            public function checkConnection()
                            {
                                if(!isset($_SESSION['connection']))
                                {
                                    $this->Logger('No connection found in current session', $_SERVER['REQUEST_TIME']); 
                                }
                                if(isset($_SESSION['connection']) and $_SESSION['connection']->active === true)
                                {
                                    $this->Logger('Connected to MySQL database successful', $_SERVER['REQUEST_TIME']);
                                }
                            }
                            public function Logger($value, $time)
                            {
                                $variable = new \stdClass();
                                $variable->message = $value;
                                $variable->timestamp = date('m/d/Y H:i:s', $time);
                                array_push($_SESSION['log'], $variable);
                                return($value);
                            }
                        }
                        $server = new server();
                        $server->checkConnection();
                    ?>
                    <form action='log.php' target='_blank'>
                        <button class='buttonLog'>View Log</button>
                    </form>
                </div>
                <div class='databases' id='c1'>
                    <h3>Available Databases</h3>
                    <div class='lineOther'></div>
                    <div class='container'><p>Database1</p></div>
                    <div class='container'><p>Database2</p></div>
                    <div class='container'><p>Database3</p></div>
                    <div class='container'><p>Database4</p></div>
                </div>
            </div>
        </div>
        </div>
    </body>
    <script src='scripts.js'></script>

</html>