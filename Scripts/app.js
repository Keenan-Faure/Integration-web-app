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
