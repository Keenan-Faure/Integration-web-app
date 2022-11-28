function changeAmount(amount)
{
    text = document.getElementById('textAmount');
    text.innerHTML = amount;
}
function createURL(parameter, sku, limit)
{
    if(parameter != 'getSKUs')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'cURL/pushStock2Shop.php?q=' + sku + '&limit=' + limit;
        return url;
    }
    else
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getSKUs.php?q=s2s';
        return url;
    }
}
const req = async function(parameter, sku) 
{
    let url = createURL(parameter, sku, '');
    const resp = await fetch(url,
    {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'include', // include, *same-origin, omit
        headers: 
        {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json'
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    });
    const json = await resp.json();
    changeAmount("0 / " + json.body.length);//sets the total amount of products to process
    process(json, '');
}
const process = async function(result)
{
    //uses the json in req to make a loop
    for(let i = 0; i < result.body.length; ++i)
    {
        let url = createURL('', result.body[i].SKU, result.body.length);
        const resp = await fetch(url,
        {
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'include', // include, *same-origin, omit
            headers: 
            {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json'
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        });
        const json = await resp.json();
        if(json.result == true)
        {
            changeAmount((i + 1) + " / " + result.body.length);//updates the process
            appendText(json.message, json.result);
        }
        else
        {
            changeAmount((i + 1) + " / " + result.body.length);////updates the process
            appendText(json.message, json.result);
        }
    }
    document.getElementById('text').innerHTML = 'Push Complete';
    document.querySelector('.container').style.backgroundImage = "url('../Images/completed.gif')";
}
function appendText(message, result)
{
    container = document.getElementById('row');
    container.classList.remove("fadeOut");
    text = document.getElementById("text-1");

    img = document.getElementById('img');
    img.className = 'type-msg-image';
    if(result == true)
    {
        img.src = '../images/image.png';
    }
    else
    {
        img.src = '../images/image1.png';
    }
    text.innerHTML = message;
    
    container.classList.add("fadeIn");
    
    //fades out after 1.5seconds
    setTimeout(()=>
    {
        container.classList.remove('fadeIn');
        container.classList.add('fadeOut');
    }, 1500);
}
req('getSKUs', '');

