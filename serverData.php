<?php 
    session_start();
    include("createConnection.php");
    use Connection\Connection as connect;
    
    if(isset($_SESSION['credentials']) && $_SESSION['credentials']->active == true)
    {
        $connection = new connect();
        $rawConnection = $connection->connectServer($_SESSION['credentials']->username, $_SESSION['credentials']->password)->rawValue;
        $_SESSION['rawconnection'] = $rawConnection;
        //creates query
        $query = 'show DATABASES';

    }
    else
    {
        if(!isset($_SESSION['credentials']))
        echo('<script>console.log("No connection to MySql detected");</script>');
    }
    
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
        <div class = 'background fade-in'>
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
                    <h2 style='color: black'>Log</h2>
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
                </div>
            </div>
        </div>
        </div>
    </body>


    <script src='scripts.js'></script>
    <?php 
        if(isset($_SESSION['credentials']) && $_SESSION['credentials']->active == true)
        {
            $counter = false;
            $cust = false;
            $knownDbs = array('information_schema', 'mysql', 'performance_schema', 'phpmyadmin', 'test');
            $connection = new connect();
            $output = $connection->converterArray($rawConnection, $query, "Database");
            $output = array_diff($output, $knownDbs);
            $_SESSION['databases'] = $output;


            for($p = 0; $p < sizeof($output); ++$p)
            {
                if(isset($_SESSION['connection']))
                {
                    $connection2 = new connect();
                    $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                    $query2 = 'show tables';
                    $output2 = $connection2->converterArray($rawConnection, $query2, "Tables_in_" . $_SESSION['connection']->credentials->dbname);
                    if('Inventory' != $output2[$p])
                    {
                        $counter = true;
                    }
                    if('Client' != $output2[$p])
                    {
                        $cust = true;
                    }
                }
                echo("<script>createContainer('$output[$p]');</script>");
            }
            if($counter)
            {
                echo("<script>console.log('Creating table Inventory');</script>");

                //creates query
                $query3 = " create table Inventory (

                        Active tinyint,
                        SKU varchar(255),
                        Title varchar(255),
                        Description varchar(255),
                        Group_Code varchar(255),
                        Category varchar(255),
                        Product_Type varchar(255),
                        Brand varchar(255),
                        Variant_Code int,
                        Barcode int,
                        Weight int,
                        Price int, 
                        Quantity int,
                        Option_1_Name varchar(255),
                        Option_1_Value varchar(255),
                        Option_2_Name varchar(255),
                        Option_2_Value varchar(255),
                        Option_3_Name varchar(255),
                        Option_3_Value varchar(255)
                    );
                ";
                
                $output = $connection2->converterObject($rawConnection, $query3);
                $counter = false;
            }
            if($cust)
            {
                echo("<script>console.log('Creating table Client');</script>");
                $query4 = " create table Client (

                    Active tinyint,
                    Name varchar(255),
                    Surname varchar(255),
                    Email varchar(255),
                    Address_1 varchar(255),
                    Address_2 varchar(255),
                    Address_3 varchar(255),
                    Address_4 varchar(255)
                );
                ";
            
            $output = $connection2->converterObject($rawConnection, $query4);
            $cust = false;
            }
            
        }
        mysqli_close($rawConnection);
    ?>
</html>