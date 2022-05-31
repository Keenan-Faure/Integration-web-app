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
                position: absolute;
                text-align: center;
                top: 13%;
                color: white;
            }
            #h2-1{ left: 5%; }
            #h2-2{ left: 45%; }
            #h2-3{ right: 5%; }
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
        </style>
    </head>
    <body>
            <div class='background'>
            </div>
            <h1>Available Endpoints</h1>
            <div class='line'></div>

            <h2 id='h2-1'>General</h2>
            <h2 id='h2-2'>Products</h2>
            <h2 id='h2-3'>Customers</h2>
    </body>
</html>