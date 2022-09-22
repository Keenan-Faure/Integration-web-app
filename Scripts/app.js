$(document).ready(()=>
{
    $('#push').click(()=>
    {
        console.log("I am here");
        console.log($('.conditions').css('opacity') == '0');
        if($('.conditions').css('opacity') == '0')
        {
            $('.conditions').fadeTo('slow', 1);
        }
        else
        {
            $('.conditions').fadeTo('slow', 0);
        }
    });
});