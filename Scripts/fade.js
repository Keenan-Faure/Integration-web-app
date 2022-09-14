//makes the variant tab fadeOut
$(document).ready(()=>
{
    $('#vDatad').click(()=>
    {
        $('#variant').fadeOut(300);
        $('#general').fadeIn(300);
    });
});

//makes the general tab fadeOut
$(document).ready(()=>
{
    $('#gData').click(()=>
    {
        $('#general').fadeOut(300);
        $('#variant').fadeIn(300);
    });
});

//makes the image fade in After 1.5 seconds
$(document).ready(()=>
{
    setTimeout(()=>
    {
        $('.backgroundtwo').fadeTo(1500, 1);
    }, 1000);
});



