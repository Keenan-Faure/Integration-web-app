/**
 * Description: creates the request url
 * @param {string} token - Session token of current user
 * @param {string} urlConfig - used to configure which func endpoint to run
 * @returns {string} url
 */
function createURL(token, urlConfig = '')
{
    if(urlConfig == 'session')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_ses';
        return url;
    }
    else if(urlConfig == 'putUsers')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_usz&token=' + token;
        return url;
    }
    else if(urlConfig == 'getUsers')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_usz&token=' + token;
        return url;
    }
    else if(urlConfig == 'putLogs')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_logs&token=' + token;
        return url;
    }
}

/**
 * Description: Appends the available (none null) params to the current url
 * @param {string} url - Current URL
 * @param {string} rqParam - First param
 * @param {string} rqParam_key - First param key
 * @param {string} rqParam_2 - Second param
 * @param {string} rqParam_key_2 - Second param key
 * @returns {string} url
 */
function appendParams(url, rqParam = '', rqParam_key = '', rqParam_2 = '', rqParam_key_2 = '')
{
    if(rqParam_key != '')
    {
        url = url + '&' + rqParam_key + '=' + rqParam;
        if(rqParam_key_2 != '')
        {
            url = url + '&' + rqParam_key_2 + '=' + rqParam_2;
        }
    }
    return url;
}

/**
 * Description: Builds user table
 * @param {JSON} json - Table is built using the json object
 * @returns {null} null
 */
function createUserTable(json)
{
    let headers = ['Active', 'UserID', 'Username', 'Token', ''];
    let userTable = document.createElement('div');
    userTable.className = 'userTable fade-out';

    arrayUrl = (document.URL).split('/');

    let tbl = document.createElement('table');
    for(let i = 0; i < json.length; ++i)
    {
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
                        if(json[i][headers[2]] != 'root')
                        {
                            let input = document.createElement('input');
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
                        }
                        tr1.appendChild(td);
                    }
                    else if(z == 4)
                    {
                        let td = document.createElement('td');
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
                            aTag.onclick = Init_function_srq_pu;
                            
                            url = json[i][headers[z-3]];
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

/**
 * Description: Creates an html button element, advises user if the call was successfull or not
 * @param {string} result - Can be true or false. True for success message, otherwise false
 * @param {string} message - message to use if the call was successful
 */
function createMessage(result, message)
{
    let button = document.createElement('button');
    let text = '';
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

/**
 * Description: Below is the list of setTimeout method which 
 * has a delayed run-time. Will only work on certain pages
 * that has the specified className
 */
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