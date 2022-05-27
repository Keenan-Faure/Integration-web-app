<?php 
    session_start();
    $_SESSION['log'] = array();
?>
<html>
    <head>
        <style>
            .log 
            {
                background-color: #f1f1f1;
                color: black;
                width: 100%;
                height: 16%;
                font-size: 18px;
                overflow: auto;
                padding-left: 10px;
                padding-right: 10px;
                padding-bottom: 10px;
                transition-duration: 0.7s;
                box-sizing: border-box;
                border: 1px solid #ccc;
            }
            .button
            {
                width: 180px;
                height: 28px;
                background-color: #f1f1f1;
                color: black;
                cursor: pointer;
                padding: 4px 12px;
                transition-duration: 0.3s;
                border-radius: 5px;
            }
            .button:hover
            {
                border: 1px solid red;
            }
            .buttonclear
            {
                position: relative;
                margin-left: 210px;
                margin-top: -44px;
                background-color: red;
                transition-duration: 0.3s;
            }
            .buttonclear:hover
            {
                border: 1px solid black;
            }
            input[type=text], input[type=password]
			{
				width: 100%;
               	display: inline-block;
				border: 1px solid #ccc;
				background-color: #f1f1f1;
				margin: 8px 0;
				padding: 12px 20px;
                box-sizing: border-box;
			}
			input[type=text]:focus, input[type=password]:focus 
			{
				background-color: #ddd;
				outline: none;
				opacity: 1;
			}
            .image
            {
                position: absolute;
                right: 50px;
                top: 10;
                border: 1px solid #f1f1f1;
            }
            .buttonLog
            {
                margin-top: -49px;
                margin-left: 60px;
                background-color: #cab5db;
                width: 100px;
                height: 24px;
                border: 1px solid grey;
                padding: 4px 12px;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <h1>Clover never falls</h1>
        <form method='post' action='output.php' target='_blank'>
            <label for='uname'>Username: </label>
            <input type='text' name='uname' placeholder='Enter Username' required>
            <br><br>
            <label for='password'>Password: </label>
            <input type='password' name='psw' placeholder='Enter Password'>
            <br><br>
            <label for='host'>Host: </label>
            <input type='text' name='host' placeholder='Localhost' readonly>
            <br><br>
            <label for='dbName'>Database Name </label>
            <input type='text' name='dbName' placeholder='Enter Database Name' required>
            <br><br>
            <input class = 'button' type='submit'>
        </form>
        <button class = 'button buttonclear'>Clear Session</button>
        <div class='log'>
            <h2 style='color: red;'>Log</h2>
            <?php    

                include("createConnection.php");
                use Connection\Connection as connect;
                
                class server
                {
                    public $timestamp;
                    private $connection;

                    public function checkConnection()
                    {
                        if(!isset($_SESSION['connection']))
                        {
                            $this->Logger('Connection not found in current session'); 
                        }
                        if(isset($_SESSION['connection']) and $_SESSION['connection']->active === true)
                        {
                            $this->Logger('Connected to MySQL database successful');
                        }
                    }
                    public function Logger($value)
                    {
                        array_push($_SESSION['log'], $value);
                        return($value);
                    }
                }

                $server = new \server();
                $server->checkConnection();
                $variable = new connect();

            ?>
        </div>
    </body>
</html>

<?php
?>
