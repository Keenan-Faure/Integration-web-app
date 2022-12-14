//takes value taken from the search field and pushes it as a url to an endpoint
    // getProductsSearch.php runs and returns the query results
//endpoint returns data and it is displayed on screen

/**
 * Run format - search() -> reqSearch() -> createSearchResults()
 */

function search(parameter)
{
    let value = document.querySelector('.search-field').value;
    if(value.length != 0)
    {
        arrayUrl = (document.URL).split('/');
        if(parameter == 'cust')
        {
            url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getSearch.php?q=' + value + '&type=cust';
            reqSearch(url, 'cust');
        }
        else if(parameter == 'prod')
        {
            url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getSearch.php?q=' + value + '&type=prod';
            reqSearch(url, 'prod');
        }
        else if(parameter == 'order')
        {
            url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getSearch.php?q=' + value + '&type=order';
            reqSearch(url, 'order');
        }
    }
}

const reqSearch = async function(url, parameter)
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
    createSearchResults(json, parameter);
}

function createSearchResults(results, parameter)
{
    form = document.getElementById('productSForm');
    if(parameter == 'cust')
    {
        for(let i = 0; i < results["result"].length; ++i)
        {        
            let dataContainer = document.createElement('button');
            dataContainer.className = 'search-result-li';
            dataContainer.name = results["result"][i]['ID'];
            dataContainer.value = results["result"][i]['ID'];
                let title = document.createElement('div');
                title.className = 'dataValues';
                    let name = document.createElement('b');
                    let text_1 = document.createTextNode('ID: ');
                    name.appendChild(text_1);

                    let text_2 = document.createTextNode(results["result"][i]['ID']);
                title.appendChild(name);
                title.appendChild(text_2);

                dataContainer.appendChild(title);

                let sku = document.createElement('div');
                sku.className = 'dataValues';
                    name = document.createElement('b');
                    text_1 = document.createTextNode('First Name: ');
                    name.appendChild(text_1);

                    text_2 = document.createTextNode(results["result"][i]['Name']);
                sku.appendChild(name);
                sku.appendChild(text_2);
            dataContainer.appendChild(sku);
            form.appendChild(dataContainer);
        }
    }
    else if(parameter == 'prod')
    {
        for(let i = 0; i < results["result"].length; ++i)
        {        
            let dataContainer = document.createElement('button');
            dataContainer.className = 'search-result-li';
            dataContainer.name = results["result"][i]['SKU'];
            dataContainer.value = results["result"][i]['SKU'];
                let title = document.createElement('div');
                title.className = 'dataValues';
                    let name = document.createElement('b');
                    let text_1 = document.createTextNode('Title: ');
                    name.appendChild(text_1);

                    let text_2 = document.createTextNode(results["result"][i]['Title']);
                title.appendChild(name);
                title.appendChild(text_2);

                dataContainer.appendChild(title);

                let sku = document.createElement('div');
                sku.className = 'dataValues';
                    name = document.createElement('b');
                    text_1 = document.createTextNode('SKU: ');
                    name.appendChild(text_1);

                    text_2 = document.createTextNode(results["result"][i]['SKU']);
                sku.appendChild(name);
                sku.appendChild(text_2);
            dataContainer.appendChild(sku);
            form.appendChild(dataContainer);
        }
    }
    else if(parameter == 'order')
    {
        for(let i = 0; i < results["result"].length; ++i)
        {        
            let dataContainer = document.createElement('button');
            dataContainer.className = 'search-result-li';
            dataContainer.name = results["result"][i]['ID'];
            dataContainer.value = results["result"][i]['ID'];
                let title = document.createElement('div');
                title.className = 'dataValues';
                    let name = document.createElement('b');
                    let text_1 = document.createTextNode('ID: ');
                    name.appendChild(text_1);

                    let text_2 = document.createTextNode(results["result"][i]['ID']);
                title.appendChild(name);
                title.appendChild(text_2);

                dataContainer.appendChild(title);

                let sku = document.createElement('div');
                sku.className = 'dataValues';
                    name = document.createElement('b');
                    text_1 = document.createTextNode('Order Status: ');
                    name.appendChild(text_1);

                    text_2 = document.createTextNode(results["result"][i]['orderStatus']);
                sku.appendChild(name);
                sku.appendChild(text_2);
            dataContainer.appendChild(sku);
            form.appendChild(dataContainer);
        }
    }
}

//Fades the search results in and out depending which element is in focus
function inFocus()
{
    const element = document.activeElement.tagName;
    if(element == 'INPUT')
    {
        s_b_fadeIn();
    }
    else if(element == 'BODY')
    {
        s_b_fadeOut();
    }
}
function s_b_fadeIn()
{
    let s_c = document.querySelector('.search-result-container');
    if(s_c.classList.contains('fade-out'))
    {
        s_c.classList.remove('fade-out');
        s_c.classList.add('fade-in');
        s_c.classList.add('top');
    }
    else
    {
        s_c.classList.add('fade-in');
        s_c.classList.add('top');
    }
}

function s_b_fadeOut()
{
    let s_c = document.querySelector('.search-result-container');
    if(s_c.classList.contains('fade-in'))
    {
        s_c.classList.remove('fade-in');
        s_c.classList.add('fade-out');
        s_c.classList.add('bottom');
        setTimeout(()=>
        {
            removeSearchResults();
        }, 500);
    }
}

function removeSearchResults()
{
    let results = document.getElementById('productSForm');
    for(let i = 0; i < results.length; ++i)
    {
        if(typeof results[i] !== 'undefined')
        {
            while (results.hasChildNodes()) 
            {
                results.removeChild(results.firstChild);
            }
        }
    }
}
