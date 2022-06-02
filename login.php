<?php 
    session_start();
    include("createConnection.php");
?>
<html>
    <head>
        <link rel='stylesheet' href='Styles/serverData.css'>
    </head>
    <body>
        <div class = 'background'>
        <div class = 'background-cover'>
            <h1 id='header1'>Login to MySql Server</h1>
            <div class='line' id='line'></div>
            <div class='next' onclick=swap()>
            </div>
            <div class="modalContainer">
                <form method='post' action='output.php' target='_blank'>
                    <input type='text' name='uname' placeholder='Enter Username' id='f1' required>
                    <br><br>
                    <input type='password' name='psw' placeholder='Enter Password' id='f2'>
                    <br><br>
                    <input type='text' name='host' placeholder='Localhost' id='f3' readonly>
                    <br><br>
                    <input type='text' class='show' name='dbName' placeholder='Enter Database' id='f4' required>
                    <br><br>
                    <input class = 'button' type='submit' id='f5'>
                </form>
                </div>
            </div>
        </div>
        </div>
    </body>

</html>

<?php
?>
