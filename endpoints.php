<html>
    <head>
        <style>
            .background
            {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;
                background-size: cover;
                background-color: rgba(0,0,0,0.2);
                background-position: center;
                background-image: url('Images/dbPicture.png');
                filter: blur(10px);
            }
            h1
            {
                text-shadow: 1px 1px 4px rgb(42, 150, 201 );
                position: relative;
                text-align: center;
                top: 10px;
                color: white;
            }
            h2
            {
                text-shadow: 1px 1px 4px rgb(42, 150, 201 );
                position: relative;
                text-align: center;
                top: 5%;
                color: white;
            }
            .container
            {
                width: 25%;
                height: 68.5%;
                left: 5%;
                box-shadow: -5px 6px 6px #888888;
                position: absolute;
                top: 13%;
                background: rgba(0,0,0,0.3);
            }
            #container-2
            {
                position: absolute;
                top: 13%;
                height: 68.5%;
                left: 37.5%;
            }
            #container-3
            {
                position: absolute;
                top: 13%;
                height: 68.5%;
                left: 70%;
            }
            .line
            {
                width: 50%;
                height: 3px;
                background-color: white;
                left: 25%;
                position: relative;
                box-shadow: 1px 1px 4px #2A96C9;
                border-radius: 20px;
            }
            #line-1{ top: 5%; opacity: 0;}
            .buttons
            {
                position: relative;
                cursor: pointer;
                background-color: rgba(0,0,0,0.2);
                width: 85%;
                opacity: 0;
                height: 10%;
                left: 7%;
                top: 10%;
                box-shadow: -2px 2px 4px #1d1f20;
                border: none;
                transition-duration: 0.4s;
            }
            .buttons:hover
            {
                border: 1px solid orange;
            }
            .buttonText
            {
                text-shadow: 1px 1px 4px rgb(42, 150, 201 );
                position: relative;
                text-align: center;
                color: white;
            }
            #container-1, #container-2, #container-3
            {
                opacity: 0;
            }
            .h2-hidden
            {
                opacity: 0;
            }
            @keyframes fades-in
            {
                from
                {
                    opacity: 0;
                }
                to
                {
                    opacity: 1;
                }
            }
            .fade-in
            {
                opacity: 0;
                animation: fades-in 1s ease-in forwards;
            }
            
        </style>
    </head>
    <body>
            <div class='background'>
            </div>
            <h1>Available Endpoints</h1>
            <div class='line'></div>
            <div class='container' id='container-1'>
                <h2 class='h2-hidden'>General</h2>
                <div class='line' id='line-1'></div>
                <button class='buttons' id='b1'><h3 class='buttonText'>Check Connection</h3></button>
                <br><br>
                <button class='buttons' id='b2'><h3 class='buttonText'>View Log</h3></button>
                <br><br>
                <button class='buttons' id='b3'><h3 class='buttonText'>Visit Stock2Shop</h3></button>
            </div>

            <div class='container' id='container-2'>
                <h2 class='h2-hidden'>Products</h2>
                <div class='line' id='line-1'></div>
                <button class='buttons' id='b4'><h3 class='buttonText'>Get Product by SKU</h3></button>
                <br><br>
                <button class='buttons' id='b5'><h3 class='buttonText'>Get Products (10)</h3></button>
                <br><br>
                <button class='buttons' id='b6'><h3 class='buttonText'>Count Products</h3></button>
                <br><br>
                <button class='buttons' id='b7'><h3 class='buttonText'>View Product Sql</h3></button>
                <br><br>
                <button class='buttons' id='b8'><h3 class='buttonText'>Add Product to Database</h3></button>
            </div>

            <div class='container' id='container-3'>
                <h2 class='h2-hidden'>Customers</h2>
                <div class='line' id='line-1'></div>
                <button class='buttons' id='b9'><h3 class='buttonText'>Get Customer by Name</h3></button>
                <br><br>
                <button class='buttons' id='b10'><h3 class='buttonText'>Count Customers</h3></button>
                <br><br>
                <button class='buttons' id='b11'><h3 class='buttonText'>View Customer Sql</h3></button>
                <br><br>
                <button class='buttons' id='b12'><h3 class='buttonText'>Add Customer to Database</h3></button>
            </div>
    </body>
        <script src='scripts2.js'></script>
</html>