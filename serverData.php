<?php 
    session_start();
    include("createConnection.php");
    use Connection\Connection as connect;
    
    if(isset($_SESSION['credentials']))
    {
        $connection = new connect();
        $connection->connectServer($_SESSION['credentials']->username, $_SESSION['credentials']->password);
    }
    else
    {

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
                    <input type='text' autocomplete="off" class='show' name='dbName' placeholder='Enter Database' required>
                    <br><br>
                    <input type='text' name='host' placeholder='Localhost' readonly>
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
                <form action='output.php' target='_blank'>
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
            </div>
        </div>
        </div>
    </body>
    <script src='scripts.js'></script>

</html>

<?php
?>
