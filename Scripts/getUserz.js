function createUserTable(json)
{
    let headers = ['Active', 'UserID', 'Username', 'Token', ''];
    let userTable = document.createElement('div');
    userTable.className = 'userTable fade-out';

    arrayUrl = (document.URL).split('/');

    let tbl = document.createElement('table');
    for(let i = 0; i < json.length; ++i)
    {
        console.log(i);
        for(let j = 0; j < 1; ++j)
        {
            if(i == 0 && j == 0)
            {
                let tr = document.createElement('tr');
                for(let z = 0; z < 5; ++z)
                {
                    let td = document.createElement('td');
                    let tdText = document.createTextNode(headers[z]);
                    td.appendChild(tdText);
                    tr.appendChild(td);
                    tbl.appendChild(tr);
                }
                tbl.appendChild(tr);

                let tr1 = document.createElement('tr');
                for(let z = 0; z < 5; ++z)
                {
                    if(z == 0)
                    {
                        let td = document.createElement('td');
                            let input = document.createElement('input');
                            input.className = 'active';
                            input.id='here';
                            input.type = 'checkbox';
                            input.name = 'active';
                            input.value= json[i][headers[z]];
                            if(json[i][headers[z]] == 'true')
                            {
                                input.checked = true;
                            }
                            else
                            {
                                input.checked = false;
                            }
                        td.appendChild(input);
                        tr1.appendChild(td);
                    }
                    else if(z == 4)
                    {
                        let td = document.createElement('td');
                            let aTag = document.createElement('button');
                            aTag.className = 'SaveBtn';
                            aTag.onclick = transform;
                            
                            url = 'http://' + arrayUrl[2] + '/' + 'endpoints/updateUser.php?q=' + json[i][headers[z-1]];
                            aTag.id = url;
                            let text = document.createTextNode('Save');
                            aTag.appendChild(text);

                        td.appendChild(aTag);
                        tr1.appendChild(td);
                    }
                    else
                    {
                        let td = document.createElement('td');
                        let tdText = document.createTextNode(json[i][headers[z]]);
                        td.appendChild(tdText);
                        tr1.appendChild(td);
                    }
                    tbl.appendChild(tr1);
                }
            }
            else
            {
                let tr = document.createElement('tr');
                for(let z = 0; z < 5; ++z)
                {
                    if(z == 0)
                    {
                        let td = document.createElement('td');
                            let input = document.createElement('input')
                            input.type = 'checkbox';
                            input.name = 'active';
                            input.id = 'active';
                            input.value = json[i][headers[z]];
                            if(json[i][headers[z]] == 'true')
                            {
                                input.checked = true;
                            }
                            else
                            {
                                input.checked = false;
                            }
                        td.appendChild(input);
                        tr.appendChild(td);
                    }
                    else if(z == 4)
                    {
                        let td = document.createElement('td');
                            let aTag = document.createElement('button');
                            aTag.className = 'SaveBtn';
                            aTag.onclick = transform;
                            
                            url = 'http://' + arrayUrl[2] + '/' + 'endpoints/updateUser.php?q=' + json[i][headers[z-1]];
                            aTag.id = url;
                            let text = document.createTextNode('Save');
                            aTag.appendChild(text);

                        td.appendChild(aTag);
                        tr.appendChild(td);
                    }
                    else
                    {
                        let td = document.createElement('td');
                        let tdText = document.createTextNode(json[i][headers[z]]);
                        td.appendChild(tdText);
                        tr.appendChild(td);
                    }
                    tbl.appendChild(tr);
                }
            }
        }
    }
    userTable.appendChild(tbl);
    document.querySelector('.userz').insertAdjacentElement("afterend", userTable);
}
function createURL(token, parameter = '')
{
    if(parameter != '')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getSession.php';
        return url;
    }
    else
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/getUserz.php?q=' + token;
        return url;
    }
}
const req = async function(token = '', parameter)
{
    let url = createURL(token, parameter)
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
    process(json);
}
const process = async function(result)
{
    //uses the json in req to make a loop
    let url = createURL(result.token,'');
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
    //create front-end
    createUserTable(json);
}
req('', 'session');


