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
            h1
            {
                text-shadow: 1px 2px 6px rgb(153, 165, 165);
                position: relative;
                text-align: center;
                top: 10px;
                color: white;
            }
            .line
            {
                width: 50%;
                height: 3px;
                background-color: white;
                left: 25%;
                position: relative;
                box-shadow: 1px 2px 6px #888888;
                border-radius: 20px;
            }
            .shiftButton
            {
                height: 120px;
                width: 120px;
                position: absolute;
                margin-top: 15%;
                margin-left: 10%;
                background-image: url('shift.png');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .log 
            {
                background-color: #f1f1f1;
                box-shadow: 1px 2px 6px #888888;
                color: black;
                text-align: center;
                width: 100%;
                height: 16%;
                font-size: 18px;
                border-radius: 20px;
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
                margin-left: 10%;
                opacity: 0.9;
                background-color: lightblue;
                color: black;
                border: 1px blue;
                cursor: pointer;
                padding: 4px 12px;
                transition-duration: 0.3s;
                border-radius: 20px;
            }
            .button:hover
            {
                border: 1px solid red;
            }
            .buttonclear
            {
                position: relative;
                margin-left: 55%;
                margin-top: -11%;
                background-color: blue;
                transition-duration: 0.3s;
            }
            .buttonclear:hover
            {
                border: 1px solid black;
            }
            .modalContainer
            {
                position: fixed;
                left: 50%;
                transform: translate(-50%, -50%);
                top: 55%;
                padding: 20px;
                opacity: 0.9;
                width: 400px;
                height: 600px;
            }
            input[type=text], input[type=password]
			{
				width: 100%;
                border-radius: 20px;
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
                border-radius: 20px;
                margin-top: 20px;
                height: 24px;
                border: 1px solid grey;
                padding: 4px 12px;
                cursor: pointer;
            }
            .background
            {
                background-image: url('Images/background.png');
                background-size: cover;
                position: absolute;
                top: 0;
                background-position: left;
                width: 100%;
                height: 100%;
            }
            .backgroundtwo
            {
                background-image: url('Images/background.png');
                background-size: cover;
                opacity: 0;
                position: absolute;
                top: 0;
                background-position: right;
                width: 100%;
                height: 100%;
            }
            .background-cover
            {
                height: 100%;
                position: absolute;
                top: 0;
                width: 100%;
                background-color: rgba(0,0,0,0.2);
            }
            @keyframes fades-out
            {
                from
                {
                    opacity: 1;
                }
                to
                {
                    opacity: 0;
                }

            }
            .fade-out
            {
                opacity: 1;
                animation: fades-out 1s ease-out forwards;
            }
            @keyframes fades-in
            {
                from
                {
                    opacity: 0;
                }
                to
                {
                    opacity: 1;
                }
            }
            .fade-in
            {
                opacity: 0;
                animation: fades-in 1s ease-in forwards;
            }
            /* ❮ ❯ */
            .next
            {
                cursor: pointer;
                position: absolute;
                right: 0;
                top: 0;
                height: 100%;
                width: 50px;
                color: white;
                font-weight: bold;
                font-size: 18px;
                transition: 0.6s ease;
                border-radius: 0 3px 3px 0;
                z-index: 10;
                background-color: rgba(0,0,0,0.5);
            }
            .nextBtn
            {
                top: 50%;
                position: absolute;
                right: -22px;
                width: 50px;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class='backgroundtwo'>
        <h1>Check Connection</h1>
            <div class='line'></div>
            <div class='next'>
            </div>
            <div class='nextBtn'>❯</div>
            <div class="modalContainer">
                <form method='post' action='output.php' target='_blank'>
                    <input type='text' name='uname' placeholder='Enter Username' required>
                    <br><br>
                    <input type='password' name='psw' placeholder='Enter Password'>
                    <br><br>
                    <input type='text' name='host' placeholder='Localhost' readonly>
                    <br><br>
                    <input type='text' name='dbName' placeholder='Enter Database Name' required>
                    <br><br>
                    <input class = 'button' type='submit'>
                </form>
                <form action='output.php' target='_blank'>
                    <?php $_SESSION['clearCache'] = true;?>
                    <button class = 'button buttonclear'>Clear Session</button>
                </form>
            </div>
        </div>
        <div class = 'background'>
        <div class = 'background-cover'>
            <h1>Check Connection</h1>
            <div class='line'></div>
            <div class='next' onclick=swap()>
            </div>
            <div class='nextBtn'>❯</div>
            <div class="modalContainer">
                <form method='post' action='output.php' target='_blank'>
                    <input type='text' name='uname' placeholder='Enter Username' required>
                    <br><br>
                    <input type='password' name='psw' placeholder='Enter Password'>
                    <br><br>
                    <input type='text' name='host' placeholder='Localhost' readonly>
                    <br><br>
                    <input type='text' name='dbName' placeholder='Enter Database Name' required>
                    <br><br>
                    <input class = 'button' type='submit'>
                </form>
                <form action='output.php' target='_blank'>
                    <?php $_SESSION['clearCache'] = true;?>
                    <button class = 'button buttonclear'>Clear Session</button>
                </form>
                <div class='log'>
                    <h2 style='color: red'>Log</h2>
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
                                $variable->timestamp = $time;
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
    <script>
        function swap()
        {
            var btn = document.querySelector('.next');
            var background = document.querySelector('.background');
            background.classList.add('fade-out');

            setTimeout(()=>
            {
                var background2 = document.querySelector('.backgroundtwo');
                background2.classList.add('fade-in');
            }, 500); 
        }
    </script>

</html>

<?php
?>
