<?php session_start(); ?>
<html>
    <head>
        <link rel='stylesheet' href='Styles/addItem.css'>
    </head>
    <body>
        <div class="bg">
            <div class="overlay">
                <h1>View Products</h1>
                <div class='line'></div>
            </div>
            <div class='containers' id='maine'>
                <div class='column1'>Active</div>
                <div class='column1' id = 'column2'>SKU</div>
                <div class='column1' id = 'column3'>Title</div>
                <div class='column1' id = 'column4'>Brand</div>
            </div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 
        
        if(isset($_SESSION['products']))
        {
            for($i = 0; $i < sizeof($_SESSION['products']->result); ++ $i)
            {
                //loop through template list...
                $title = $_SESSION['products']->result[$i]->Title;
                $sku = $_SESSION['products']->result[$i]->SKU;
                $active = $_SESSION['products']->result[$i]->Active;
                $brand = $_SESSION['products']->result[$i]->Brand;
                echo("<script>createPLV('". $i+1 . ".  " . $active . "','" . $sku . "','" . $title . "','" . $brand . "','" . $sku . "');</script>");
            }
        } 
    ?>
</html>