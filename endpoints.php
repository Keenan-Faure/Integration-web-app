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
                width: 300px;
                height: 70%;
                box-shadow: -5px 6px 6px #888888;
                position: relative;
                top: 10px;
                background: rgba(0,0,0,0.2);
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
            #line-1{ top: 5%; }
            .buttons
            {
                position: relative;
                cursor: pointer;
                background-color: rgba(0,0,0,0.2);
                padding: 16px;
                width: 140px;
                height: 20px;
            }
        </style>
    </head>
    <body>
            <div class='background'>
            </div>
            <h1>Available Endpoints</h1>
            <div class='line'></div>
            <div class='container'>
                <h2>General</h2>
                <div class='line' id='line-1'></div>
            </div>
            
            


    </body>
</html>