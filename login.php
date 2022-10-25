<?php 
    session_start();
    include('createConnection.php');
    use Connection\Connection as connect;

    $_config = include('config/config.php');
    $_SESSION['log'] = array();

    if(!isset($_SESSION['setTables']))
    {
        $conn = new connect(); 
        $query = 'SHOW TABLES';
        $result = $conn->preQuery($_config, $query, 'array');
        for($i = 0; $i < sizeof($result); ++$i)
        {
            $result[$i] = strtolower($result[$i]);
        }
        if(!in_array("users", $result))
        {
            //create the table
            $query = 'CREATE TABLE Users(
                UserID int AUTO_INCREMENT primary key NOT NULL,
                Username varchar(255),
                Password varchar(255),
                Email varchar(255)
                )';
            $result = $conn->preQuery($_config, $query, 'object');   
            if(isset($result->result) == true)
            {
                if($result->result == true)
                {
                    $_SESSION['setTables'] = true;
                }
            }
        }
    }
?>


<?php
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='Styles/login.css'>
    </head>
    <body>
        <div class = 'background'>
        <div class = 'background-cover'>
            <h1 id='header1'>Login to MySql Server</h1>
            <div class='line' id='line'></div>
            </div>
            <div class="modalContainer">
                <form method='post' action='connect.php'>
                    <input type='text' autocomplete="off" name='uname' placeholder='Enter Username' id='f1' required>
                    <br><br>
                    <input type='password' autocomplete="off" name='psw' placeholder='Enter Password' id='f2'>
                    <br><br>
                    <input type='text' name='host' placeholder='Localhost' id='f3' readonly>
                    <br><br>
                    <input class = 'button' type='submit' id='f4'>
                </form>
                </div>
            </div>
        </div>
        </div>
    </body>
    <script src='Scripts/script3.js'></script>
</html>