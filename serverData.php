<?php 
    session_start();
    $_SESSION['log'] = array();
?>
<html>
    <head>
        <style>
            body
            {
                margin: 0;
                font-family: 'Arial, Helvetica, sans-serif';
            }
            .log 
            {
                background-color: #f1f1f1;
                box-shadow: 1px 2px 6px #888888;
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
                width: 140px;
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
                margin-left: 160px;
                margin-top: -44px;
                background-color: red;
                transition-duration: 0.3s;
            }
            .buttonclear:hover
            {
                border: 1px solid black;
            }
            .modalContainer
            {
                
                position: fixed;
                margin: 5% 20%;
                background: white;
                padding: 20px;
                opacity: 0.97;
                width: 60%;
                height: 80%;
                border-radius: 4px;
                border: 1px solid #42428e
            }
            input[type=text], input[type=password]
			{
				width: 100%;
               	display: inline-block;
				border: 1px solid #ccc;
                box-shadow: 1px 2px 6px #888888;
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
                background-color: #cab5db;
                width: 100px;
                margin-top: 20px;
                height: 24px;
                border: 1px solid grey;
                padding: 4px 12px;
                border-radius: 5px;
                cursor: pointer;
            }
            .background
            {
                background-image: url('Images/background.png');
                
                width: 100%;
                height: 100%;
                
            }
            .background-cover
            {
                height: 100%;
                width: 100%;
                background-color: rgba(0,0,0,0.8);
            }
        </style>
    </head>
    <body>
        <div class = 'background'>
        <div class = 'background-cover'>
            <div class="modalContainer">
                <h1>Login</h1>
                <form method='post' action='output.php' target='_blank'>
                    <label for='uname'>Username</label>
                    <input type='text' name='uname' placeholder='Enter Username' required>
                    <br><br>
                    <label for='password'>Password</label>
                    <input type='password' name='psw' placeholder='Enter Password'>
                    <br><br>
                    <label for='host'>Host</label>
                    <input type='text' name='host' placeholder='Localhost' readonly>
                    <br><br>
                    <label for='dbName'>Database Name</label>
                    <input type='text' name='dbName' placeholder='Enter Database Name' required>
                    <br><br>
                    <input class = 'button' type='submit'>
                </form>
                <form action='output.php' target="_blank">
                    <button class = 'button buttonclear'>Clear Session</button>
                </form>
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
                                array_push($_SESSION['log'], (sizeof($_SESSION['log']) + 1) . '  -  ' . $value);
                                return($value);
                            }
                        }
                        $server = new server();
                        $server->checkConnection();
                    ?>
                    <form action='log.php' target='_blank'>
                        <button class='buttonLog'>Update Log</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>

<?php
?>
