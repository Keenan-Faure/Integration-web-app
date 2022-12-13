function search()
{
    let value = document.querySelector('.search-field').value;
    if(value.length != 0)
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getProductsSearch.php?q=' + value;
        reqSearch(url);
    }
}

const reqSearch = async function(url)
{
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
    console.log(json);
}
//takes value and pushes it as a url to endpoint
    //getProductsSearch.php
//endpoint returns data and it is displayed on screen

function createSearchResults(results)
{
    
}