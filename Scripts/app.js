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

function createCondition(queryData)
{
    main = document.getElementById('c1');
    if(name != null)
    {
        var container = document.createElement('div');
        container.classList.add('container');

        var word = document.createElement('p');
        word.appendChild(document.createTextNode(name));

        container.appendChild(word);
        container.classList.add('fade-in');
        main.appendChild(container);
    }
}

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
