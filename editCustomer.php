<?php session_start(); ?>
<html>
    <head>
        <link rel='stylesheet' href='Styles/addItem.css'>
    </head>
    <body>
        <div class="bg">
            <div class="navBar">
            <div class="overlay">
                <h1>Edit Customer</h1>
            </div>
            </div>
            <div class='containers' id='maine'>
                <div class='column1'>Active</div>
                <div class='column1' id = 'column2'>Name</div>
                <div class='column1' id = 'column3'>Surname</div>
                <div class='column1' id = 'column4'>Email</div>
            </div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 
        
        if(isset($_SESSION['customers']))
        {
            for($i = 0; $i < sizeof($_SESSION['customers']->result); ++ $i)
            {
                //loop through template list...
                $name = $_SESSION['customers']->result[$i]->Name;
                $surname = $_SESSION['customers']->result[$i]->Surname;
                $active = $_SESSION['customers']->result[$i]->Active;
                $email = $_SESSION['customers']->result[$i]->Email;
                $id = $_SESSION['customers']->result[$i]->ID;
                echo("<script>createCLV('". $i+1 . ".  " . $active . "','" . $name . "','" . $surname . "','" . $email . "','" . $id . "');</script>");
            }
        } 
    ?>
</html>