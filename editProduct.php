<?php session_start(); ?>
<html>
    <head>
        <link rel='stylesheet' href='Styles/addItem.css'>
    </head>
    <body>
        <div class="bg">
            <div class="overlay">
                <h1>Edit Product</h1>
                <div class='line'></div>
            </div>
            <div class='containers' id='main'>
                <div class='fullsize'></div>
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
                for($j = 0; $j < sizeof($productTemplateDB); ++ $j)
                {
                    $template = $productTemplateDB[$j];
                    //echo("<script>createTA('prev', 'current','" . $_SESSION['products']->result[0]->$template . "','" . $template . "');</script>");
                }
            }
        } 
    ?>
</html>