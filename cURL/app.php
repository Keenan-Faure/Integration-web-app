

<?php
session_start();
include('cURL.php');
use cURL\CURL as curl;

$token = null;
$delay = 3;

//should check at post form already, if the credentials are valid
//$username = $_POST['username'];
//$password = $_POST['password'];

$curl = new curl();
/*
$result = $curl->authenticate('keenan.faure', 'Re_Ghoul');

while($token == null)
{
    if($result->httpcode != '200' || isset($result->errors) || $token == null)
    {
        //if the token is not set -- the first time the program runs
        $result = $curl->authenticate('keenan.faure', 'Re_Ghoul');
        $token = $result->system_user->token;
    }
    //otherwise set the token -- decide to use $_SESSION or not
    else
    {
        $token = $result->system_user->token;
        //print_r($token);
    }
    //sleep($delay);
}
*/


//All Data here, username, password, token must come from $_SESSION variables stored inside the session -- consider again.

//print_r(json_encode($curl->getSources('PGADBZNS7GNUG4SVGZK1DBIW5COQZBK98DPY38SD','keenan.faure', 'Re_Ghoul')));
//print_r(json_encode($curl->authenticate('keenan.faure', 'Re_Ghoul')));
//print_r(json_encode($curl->validateToken('PGADBZNS7GNUG4SVGZK1DBIW5COQZBK98DPY38SD','keenan.faure', 'Re_Ghoul')));
//print_r(json_encode($curl->getChannels('PGADBZNS7GNUG4SVGZK1DBIW5COQZBK98DPY38SD','keenan.faure', 'Re_Ghoul')));
//

//make a condition based on the returned values httpcode and errors
//if httpcode is 200 and error is not defined and token is defined then proceed.
//else if error code is not 200 and errors is defined then display error, stop process.
?>

<html>
    <link rel='stylesheet' href='../Styles/addItem.css'>
    <body>
    <div class='backgroundApp'>
    <div class="navBar">
                <div class="overlay">
                    <div class='imageNav'></div>
                    <h1>App</h1>
                    <div class='buttonContainer2'>
                        <div class="dropDown">
                        <button class="dropDownBtn">Home</button>
                            <div class="dropDownContent">
                                <a href="serverData.php">Dashboard</a>
                            </div>
                        </div>
    
                        <div class="dropDown">
                        <button class="dropDownBtn">Endpoints</button>
                            <div class="dropDownContent">
                                <a href="endpoints.php">View Endpoints</a>
                                <a href="API/document.html" target='_blank'>API</a>
                            </div>
                        </div>
                    </div>
                    <div class='buttonContainer'>
                        <div class="dropDown">
                        <button class="dropDownBtn">Products</button>
                            <div class="dropDownContent">
                                <a href="addItem.html">Add Product</a>
                                <a href="editProduct.php">View all products</a>
                            </div>
                        </div>
    
                        <div class="dropDown">
                        <button class="dropDownBtn">Customers</button>
                            <div class="dropDownContent">
                                <a href="addCustomer.html">Add Customer</a>
                                <a href="editCustomer.php">View Customers</a>
                            </div>
                        </div>
                    </div>
                    <a href="Import utilities/import.html" class="buttonOption"></a>
    
                    </div>
                </div>
        <div class='modalContainer'>
            <form action="execute.php" method='post' target='_blank'>
                <select id="cars" name="cars">
                    <option value="authenticate">Authenticate User</option>
                    <option value="validToken">Validate Current Token</option>
                    <option value="getSources">Get Sources</option>
                    <option value="getChannels">Get Channels</option>
                </select>
            <input type="submit">
        </div>
    </div>
</html>

