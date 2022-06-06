<?php 
    session_destroy();
    session_start();
    $_SESSION['log'] = array();
    $_SESSION['databases'] = array();
?>
<html>
    <head>
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
    <script src='script3.js'></script>
</html>

<?php
?>
