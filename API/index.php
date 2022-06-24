<html>
    <head>
        <style>
            input[type=text], input[type=password], select
            {
                position: relative;
                transform: translate(0%, 50%);
                width: 90%;
                left: 5%;
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
            .container
            {
                position: absolute;
                opacity: 0.9;
                background-color: rgba(100, 100, 100, 0.6);
                border-radius: 15px;
                top: 40%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 25%;
                height: 25%;
            }
            body
            {
                margin: 0;
            }
            .button
            {
                width: 140px;
                position: absolute;
                left: 50%;
                height: 28px;
                opacity: 0.9;
                background-color: white;
                transform: translate(-50%, -50%);
                color: black;
                border: 1px blue;
                cursor: pointer;
                padding: 4px 12px;
                transition-duration: 0.3s;
                border-radius: 20px;
            }
            .button1
            {
                width: 60px;
                position: absolute;
                right: 0;
                height: 18px;
                top: 93%;
                opacity: 0.9;
                background-color: #136a13;
                transform: translate(-50%, -50%);
                color: black;
                border: 1px blue;
                cursor: pointer;
                padding: 1.5px 12px;
                transition-duration: 0.3s;
                border-radius: 20px;
                transition-duration: 1s;
            }
            .button1:hover
            {
                background-color: white;
            }
            .background
            {
                background-position: center;
                background-size: cover;
                margin: 0;
                background-repeat: no-repeat;
                background-image: url('../Images/apis.jpeg');
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        <div class='background'>
            <div class='container'>
            <form action='../connect.php' method='post'>
                <input placeholder='Token' name='api-name' type='text' autocomplete='off' required>
                <input placeholder='Secret' name='api-password' type='password' autocomplete='off' required>
                <br><br><br>
                <input type='submit' class='button'>
            </form>
            <button class='button1' onclick='window.location.href="../connect.php"'>Forgot</button>
            </div>
        </div>
    </body>
</html>