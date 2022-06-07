<?php 
    session_start();
    include("createConnection.php");
    use Connection\Connection as connect;
    
    
    if(isset($_SESSION['credentials']) && $_SESSION['credentials']->active == true)
    {
        $connection = new connect();
        $rawConnection = $connection->connectServer($_SESSION['credentials']->username, $_SESSION['credentials']->password)->rawValue;
        //creates query
        $query = 'show DATABASES';
        $resultArray = array();

        if($result = mysqli_query($rawConnection, $query))
        {
            $array = array();
            while($row = $result->fetch_object())
            {
                $array = $row;
                array_push($resultArray, $array);
            }
            $resultArray = json_encode($resultArray); //converts it to a PHP object
            echo($resultArray);
        }
        echo("<script>console.log('I am here');</script>");

    }
    else
    {
        //the user isnt logged in, display mess
    }
    
    
    //if connected get and then show databases
    //if not connected, try to make a header that refreshes the page once the user logins to the database, then we run the program again to check.
    //finally we use the script 'scripts.js' to display the databases once the user hovers over the dbName input tag.
?>

