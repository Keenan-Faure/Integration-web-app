$(document).ready(()=>
{
    $('#push').click(()=>
    {
        if($('.conditions').css('opacity') == '0')
        {
            $('.conditions').css({
                "z-index": "1", 
                "opacity": "1"
            })
        }
        else
        {
            $('.conditions').css({
                "z-index": "-1", 
                "opacity": "0"
            })
        }
    });
});

$(document).ready(()=>
{
    $('#push-s2s').click(function(event)
    {
        if (!confirm('Push active products to Stock2Shop?'))
        {
            event.preventDefault(); 
        }
        else
        {

        }
    });
});
