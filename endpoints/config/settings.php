<?php

    session_start();
    include("../../createConnection.php");
    use Connection\Connection as connect;
    if(!isset($_SESSION['clientConn']) && !isset($_SESSION['connection']))
    {
        $conn = new connect();
        $message = 'No Session found for this user';
        $solution = 'Please relog';
        $link = 'login';
        echo("
            <html>
                <head>
                    <link rel='icon' type=image/x-icon' href='Images/logo.png'/>
                </head>
                <body>
                    <div>
                    </div>
                    <div>
                        <div>
                        </div>
                        <div>
                            <h2>Message</h2>          
                            <p>$message</p>
                            <hr>
                            <p>$solution</p>
                            <div >
                                <a href='../../$link.php'>Redirect</a>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        ");
        exit();
    }

    $_settings = include('../../config/settings.php');
    function isJson($value)
    {
            json_decode($value);
            return json_last_error() === JSON_ERROR_NONE;
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="../../Styles/endpoints.css">
        <link rel="icon" type="image/x-icon" href="../../Images/logo.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
    <div class='background'>
    </div>
    <div class="navBar">
            <div class="overlay">
                <div class='imageNav'></div>
                <h1 class='navBarHeader'>Settings</h1>
                <div class='buttonContainer2'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Session</button>
                        <div class="dropDownContent">
                            <a href="../../output.php?q=session">Current session</a>
                            <a href="../../output.php?logout=true">Logout</a>

                        </div>
                    </div>

                    <div class="dropDown">
                    <button class="dropDownBtn">View API</button>
                        <div class="dropDownContent">
                            <a href='../../API/v1.php'>Visit API</a>
                            <a href="../../API/document.html" target='_blank'>Documentation</a>
                            <a href='../../API/API-collection.json' download='collection.json'>Postman collection</a>
                        </div>
                    </div>
                </div>
                <div class='buttonContainer3'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Settings</button>
                        <div class="dropDownContent">
                            <a href="../../endpoints/config/settings.php">View Settings</a>
                        </div>
                    </div>
                </div>
        </div>
        <div class='settings'>
            <?php
                foreach($_settings as $x => $value)
                {
                    echo("<div class='headerSett'><p class='headSettText'>$x</p></div>");
                    if(sizeof($value) > 0)
                    {
                        foreach($value as $y => $subValue)
                        {
                            echo("<textarea class='valueSett' style='resize:none' readonly>$y</textarea>");
                            if(str_starts_with("$subValue", "{"))
                            {
                                echo("<textarea class='valueSett' style='text-align: left' readonly>$subValue</textarea>");
                            }
                            else
                            {
                                echo("<textarea class='valueSett' readonly>$subValue</textarea>");
                            }
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>