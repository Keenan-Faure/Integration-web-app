<?php 
    session_start();
    include('createConnection.php');
    use Connection\Connection as connect;

    $_config = include('config/config.php');
    $conn = new connect();

?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='Styles/register.css'>
    </head>
    <body>
        <div class = 'background'>
        <div class = 'background-cover'>
            <a class='close'>&times;</a>
            <div class="modalContainer">
                <div class='img'></div>
                <hr>
                <p class='heading'>Registration</p>
                <hr>
                <br>
                <form method='post' action='connect.php'>
                    <input type='text' autocomplete="off" name='runame' placeholder='Enter Username' required>
                    <br><br>
                    <input type='password' autocomplete="off" name='rpsw' placeholder='Enter Password'>
                    <br><br>
                    <input type='email' autocomplete="off" name='mail' placeholder='Enter Email Address'>
                    <br><br>
                    <textarea type='text' class='textarea' autocomplete="off" name='note' placeholder='Additional Information'></textarea>
                    <br><br>
                    <input class = 'button' type='submit' id='f4'>
                </form>
                <button onclick="window.location.href='login.php'" class='back'>Return</button>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>