<?php 
    session_start();
    include('createConnection.php');
    use Connection\Connection as connect;

    $_config = include('config/config.php');
    $_SESSION['log'] = array();
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
            Active varchar(5),
            UserID int AUTO_INCREMENT primary key NOT NULL,
            Username varchar(255),
            Password varchar(255),
            Email varchar(255),
            Notes TEXT)';

        $result2 = $conn->preQuery($_config, $query, 'object');   
        if(isset($result2->result) == true)
        {
            if($result2->result == true)
            {
                $_SESSION['setTables'] = true;
            }
        }

        //create admin user
        $query = 'SELECT COUNT(*) as total FROM Users WHERE Username = "' . $_config['dbName'] . '" & Password = "' . $_config['dbPass'] . '"';
        $result3 = $conn->preQuery($_config, $query, 'object');
        if($result3->result[0]->total == 0)
        {
            //create admin user
            $query = 'INSERT INTO Users(Username, Password) VALUES("' . $_config['dbUser'] . '", "'. $_config['dbPass'] .'")';
            $result3 = $conn->preQuery($_config, $query, 'object');
        }
    }
    if(!in_array("logs", $result))
    {
        //create the table
        $query = 'CREATE TABLE Logs(
            Head varchar(255),
            Body varchar(255),
            T_ime varchar(255),
            T_ype varchar(255))';
        $result = $conn->preQuery($_config, $query, 'object');

        //create admin user
        $query = 'INSERT INTO Users(Username, Password) VALUES("' . $_config['dbUser'] . '", "'. $_config['dbPass'] .'")';
        $result = $conn->preQuery($_config, $query, 'object');
    }
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='Styles/login.css'>
    </head>
    <body>
        <div class = 'background'>
        <div class = 'background-cover'></div>
            <h1 id='header1'>Login to MySql Server</h1>
            <div class='line' id='line'></div>
            <div class="modalContainer">
                <form method='post' action='connect.php'>
                    <input type='text' autocomplete="off" name='uname' placeholder='Enter Username' id='f1' required>
                    <br><br>
                    <input type='password' autocomplete="off" name='psw' placeholder='Enter Password' id='f2' required>
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