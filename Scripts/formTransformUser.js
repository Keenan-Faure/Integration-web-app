const reqPut = async function(url)
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
    createMessage(json, 'Updated user successfully');
    //create html element displaying success/failure
}

//transform the url
//adds the active field (set on checkbox)
function transform()
{
    let url = this.id;
    let active = this.parentElement.parentElement.firstChild.childNodes[0].checked;
    url = url + '&active=' + active;
    reqPut(url);
}

setTimeout(()=>
{
    $(document).ready(()=>
    {
        logs = document.getElementsByClassName("closer");
        for(let i = 0; i < logs.length; ++i)
        {
            logs[i].addEventListener('click', ()=>
            {
                logs[i].parentNode.style.display = 'none';
            });
        }
    });
}, 1500);

function InitUpdateLogs()
{
    //requests session information to connect to database
    req('', 'session', 'logs', this.id);
}

const updateLogs = async function(json, urlConfig, reqParameter, reqParamK)
{
    let url = createURL(json.token, urlConfig);
    url = url + '&' + reqParamK + '=' + reqParameter;
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
    const jsonResults = await resp.json();
    createMessage(jsonResults, 'Success');
}

function createMessage(result, message)
{
    let button = document.createElement('button');
    let text = '';
    console.log(result);
    if(result.return != false)
    {
        button.className = 'htmlMessage-success';
        text = document.createTextNode(message);
        button.appendChild(text);

        document.body.appendChild(button);
    }
    else if(result.return != true)
    {
        button.className = 'htmlMessage-failure';
        text = document.createTextNode(result.body);
        button.appendChild(text);

        document.body.appendChild(button);
    }
    setTimeout(()=>
    {
        button.classList.add('fade-out');
        setTimeout(()=>
        {
            button.remove();
        }, 1200);
    }, 2000);
}