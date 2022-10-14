
<head>
    <style>
    .align
    {
        position: fixed;
        top: 65%;
        left: 50%;
        text-align: center;
        padding-top: 9px;
        margin:0;
        transform: translate(-50%, -50%);
        text-decoration: none;
        width: 200px;
        height: 30px;
        transition-duration: 0.4s;
        background-color: rgba(0,0,0,0.7);
        border-radius: 5px;
    }
    .align:hover
    {
        background-color: rgba(20,21,67,0.7);
        color: white;
    }
    body
    {
        background-color: rgba(0,0,0,0.9);
        margin: 0;
    }
    .background
    {
        background-image: url(rep.png);
        border-radius: 10px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: fixed;
        left: 50%;
        top:50%;
        transform: translate(-50%, -50%);
        width: 30%;
        height: 30%;
        transition-duration: 0.5s;
    }
    </style>
</head>
<div class='background'>
    <a href='login.php' class='align'>Click here to proceed</a>
</div>
