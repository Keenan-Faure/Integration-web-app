<?php 
    session_start();
    include("../../Class Templates/createConnection.php");
    use Connection\Connection as connect;
    
    if(isset($_SESSION['credentials']) && $_SESSION['credentials']->active == true)
    {
        $connection = new connect();
        $rawConnection = $connection->connectServer($_SESSION['credentials']->username, $_SESSION['credentials']->password)->rawValue;
        $_SESSION['rawconnection'] = $rawConnection;
        //creates query
        $query = 'show DATABASES';

    }
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='Styles/serverData.css'>
    </head>
    <body>
        <div class='backgroundtwo'>
        <h1>Create Connection to Database</h1>
            <div class='line'></div>
            <div class='next2'onclick=swap2()>
            </div>
            <div class='nextBtn2'>❮</div>
            <div class="modalContainer">
                <form method='post' action='../controllers/connect.php' target='dashboard.php'>
                    <input type='text' name='host' placeholder='Localhost' readonly>
                    <br><br>
                    <input type='text' autocomplete="off" class='show' name='dbName' placeholder='Enter Database' required>
                    <br><br>
                    <input class='buttonother' type='submit'>
                    <br><br>
                </form>
                <div class='line'></div>
                <div class='api'>
                    <h3>View <b>API</b></h3>
                    <div class='lineOther'></div>
                    <div class='container2' onclick='window.location.href="API/document.html"'>
                        <p>Documentation</p>
                    </div>
                    <a style='text-decoration: none' href='API/API-collection.json' download='collection.json'><div class='container2'>
                        <p>Download Postman Collection</p>
                    </div></a>
                </div>
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
                <form method='post' action='../controllers/output.php' target='_blank'>
                    <input type='text' name='host' placeholder='Localhost' id='f3' readonly>
                    <br><br>
                    <input type='text' autocomplete="off" class='show' name='dbName' placeholder='Enter Database' id='f4' required>
                    <br><br>
                    <input class='button' type='submit' id='f5'>
                </form>
                <form action='../controllers/output.php'>
                    <?php $_SESSION['clearCache'] = true;?>
                    <button class = 'button buttonclear' id='f6'>Clear Session</button>
                </form>
                <div class='line' id='f7'></div>

    
                <div class='databases' id='c1'>
                    <h3>Available Databases</h3>
                    <div class='lineOther'></div>
                </div>
            </div>
        </div>
        </div>
    </body>


    <script src='../../Scripts/scripts.js'></script>
    <?php 
        if(isset($_SESSION['credentials']) && $_SESSION['credentials']->active == true)
        {
            $counter = false;
            $cust = false;
            $knownDbs = array('information_schema', 'mysql', 'performance_schema', 'phpmyadmin', 'test', 'sys');
            $connection = new connect();
            $output = $connection->converterArray($rawConnection, $query);
            $output = array_diff($output, $knownDbs);
            $_SESSION['databases'] = $output;
            //displays the tables found in that specific database
            for($p = 0; $p < sizeof($output); ++$p)
            {
                /*
                //displays the tables found in that specific database
                if(isset($_SESSION['connection']))
                {
                    $connection2 = new connect();
                    $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                    $query2 = 'show tables';
                    $output2 = $connection2->converterArray($rawConnection, $query2);
                }
                */
                echo("<script>createContainer('$output[$p]');</script>");
                echo("<br>");
            }
        }
        if(isset($rawConnection))
        {
            mysqli_close($rawConnection);
        }
    ?>
</html>