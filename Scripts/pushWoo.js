function changeAmount(amount)
{
    text = document.getElementById('textAmount');
    text.innerHTML = amount;
}
function createURL(parameter, sku)
{
    if(parameter != 'getSKUs')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'cURL/pushWoocommerce.php?q=' + sku;
        return url;
    }
    else
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getSKUs.php';
        return url;
    }
}
const req = async function(parameter, sku) 
{
    let url = createURL(parameter, sku);
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
const process = async function(result, parameter)
{
    //uses the json in req to make a loop
    for(let i = 0; i < result.body.length; ++i)
    {
        let url = createURL(parameter, result.body[i].SKU);
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
            //change html (success)
        }
        else
        {
            changeAmount((i + 1) + " / " + result.body.length);////updates the process
            //process was (a failure) logged
        }
    }
    //replace main image with completed
    
}
req('getSKUs', '');


