/**
 * creates the request url
 * @param {string} token - Session token of current user
 * @param {string} urlConfig - used to configure which func endpoint to run
 * @returns {string} url
 */
function createURL(token, urlConfig = '')
{
    if(urlConfig == 'putUsers')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_usz';
        return url;
    }
    else if(urlConfig == 'getUsers')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_usz';
        return url;
    }
    else if(urlConfig == 'putLogs')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_logs';
        return url;
    }
    else if(urlConfig == 'getIDs')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_ids';
        return url;
    }
    else if(urlConfig == 'putCond_add')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_cond_add' + token[0];
        return url;
    }
    else if(urlConfig == 'putCond_del')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_cond_del' + token[0];
        return url;
    }
    else if(urlConfig == 'getSKU')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_sku';
        return url;
    }
    else if(urlConfig == 'pushWoo')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'cURL/push_woo.php?token=auto';
        return url;
    }
    else if(urlConfig == 'pushS2S')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'cURL/push_s2s.php';
        return url;
    }
    else if(urlConfig == 'cust')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_search';
        return url;
    }
    else if(urlConfig == 'prod')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_search';
        return url;
    }
    else if(urlConfig == 'order')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_search';
        return url;
    }
    else if(urlConfig == 'putProd_del')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_prod_del';
        return url;
    }
    else if(urlConfig == 'putUser_del')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=put_usz_del';
        return url;
    }
    else if(urlConfig == 'getPush_s2s')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_s2s_push_status';
        return url; 
    }
    else if(urlConfig == 'getPush_woo')
    {
        arrayUrl = (document.URL).split('/');
        url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_woo_push_status';
        return url; 
    }
}

/**
 * Appends the available (none null) params to the current url
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
 * Builds user table
 * @param {JSON} json - Table is built using the json object
 * @returns {null} null
 */
function createUserTable(json)
{
    let headers = ['Active', 'UserID', 'Username', 'Token', '', ''];
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
                for(let z = 0; z < 6; ++z)
                {
                    let td = document.createElement('td');
                    let tdText = document.createTextNode(headers[z]);
                    td.appendChild(tdText);
                    tr.appendChild(td);
                    tbl.appendChild(tr);
                }
                tbl.appendChild(tr);

                let tr1 = document.createElement('tr');
                for(let z = 0; z < 6; ++z)
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
                    else if(z == 5)
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
                for(let z = 0; z < 6; ++z)
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
                    else if(z == 5)
                    {
                        let td = document.createElement('td');
                            let aTag = document.createElement('button');
                            aTag.className = 'RemoveBtn';
                            
                            let text = document.createTextNode('Delete');
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
 * Creates an html button element, advises user if the call was successfull or not
 * @param {string} result - Can be true or false. True for success message, otherwise false
 * @param {string} message - message to use if the call was successful
 */
function createMessage(result, message)
{
    let button = document.createElement('button');
    let text = '';
    if(result.return == true)
    {
        button.className = 'htmlMessage-success';
        text = document.createTextNode(message);
        button.appendChild(text);

        document.body.appendChild(button);
    }
    else if(result.return == false)
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
 * adds Connector details to the DOM
 * @param {string} p_id - parent ID
 * @param {string} v_id - variant ID
 * @param {string} s2s_active - Stock2Shop active
 */ 
function addConnectorDetails(p_id, v_id, s2s_active)
{
    if(p_id == null)
    {
        document.querySelector('.p_id').innerHTML = 'null';
    }
    else
    {
        document.querySelector('.p_id').innerHTML = p_id;
    }
    if(v_id == null)
    {
        document.querySelector('.v_id').innerHTML = 'null';
    }
    else
    {
        document.querySelector('.v_id').innerHTML = v_id;
    }
    if(s2s_active == null)
    {
        document.querySelector('.s2s_active').innerHTML = 'null';
    }
    else
    {
        document.querySelector('.s2s_active').innerHTML = s2s_active; 
    }
}

/**
 * Populates the audit trail in DOM
 * @param {string} user - user that logged on session
 * @param {string} date - date that the change was made
 */
function populateAuditTrail(user, date)
{
    if(user == null)
    {
        user = "{{null}}";
    }
    if(date == null)
    {
        date = "{{null}}";
    }
    document.querySelector(".auditTrail").innerHTML = "Last update on " + date + " by User: " + user;
}

/**
 * Changes the amount on the DOM
 * @param {string} amount - Value to update the DOM with
 */
function changeAmount(amount)
{
    text = document.getElementById('textAmount');
    text.innerHTML = amount;
}
/**
 * Changes the DOM to show the complete message
 */
function changeComplete()
{
    document.querySelector('.container').style.backgroundImage = "url('../Images/completed.gif')"
}

/**
 * Appends image/text to DOM
 * @param {string} message - message to append
 * @param {string} result - true/false result of cURL request
 */
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
    setTimeout(()=>
    {
        container.classList.remove('fadeIn');
        container.classList.add('fadeOut');
    }, 1500);
}

/**
 * Creates the conditions as a single param
 * @param {string} element - The button that is pressed
 * @returns {string} string
 */
function create_cond_params(element)
{
    let array = ['dataValue', 'statement', 'value'];
    let children = element.parentElement.children;
    let string = '&';
    for(let i = 0; i < 3; ++i)
    {
        if(i != 0)
        {
            string = string + "&" + array[i] + "=" + children[i].value;
        }
        else
        {
            string = string + array[i] + "=" + children[i].value;
        }
    }
    return string;
}

/**
 * Creates the conditions as a single param
 * @param {string} element - The button that is pressed
 * @returns {string} string
 */
function create_cond_params_del(element)
{
    let array = ['dataValue', 'statement', 'value'];
    let string = element.parentElement.children[1].innerHTML;
    string = string.trim();
    string = string.split(" ");
    let value = '&';
    for(let i = 0; i < string.length; ++i)
    {
        if(i != 0)
        {
            value = value + "&" + array[i] + "=" + string[i];
        }
        else
        {
            value = value + array[i] + "=" + string[i];
        }
    }
    return value;
}

/**
 * creates search results
 * @param {string} results json results from endpoint
 * @param {string} parameter used to specify which filter to use
 */
function createSearchResults(results, parameter)
{
    form = document.getElementById('productSForm');
    if(parameter == 'cust')
    {
        for(let i = 0; i < results["result"].length; ++i)
        {        
            let dataContainer = document.createElement('button');
            let hr = document.createElement('hr');
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
            form.appendChild(hr);
        }
    }
    else if(parameter == 'prod')
    {
        for(let i = 0; i < results["result"].length; ++i)
        {        
            let dataContainer = document.createElement('button');
            let hr = document.createElement('hr');
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
            form.appendChild(hr);
        }
    }
    else if(parameter == 'order')
    {
        for(let i = 0; i < results["result"].length; ++i)
        {        
            let dataContainer = document.createElement('button');
            let hr = document.createElement('hr');
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
            form.appendChild(hr);
        }
    }
}

/**
 * Fades the search results in and out depending which element is in focus
 * @param
 */
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

/**
 * Removes search results from DOM
 * @param
 */
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

/**
 * Removes deleted User (tr) from the table in the DOM
 */
function removeUserDOM(element)
{
    (element.parentElement.parentElement).remove();
}

/**
 * Creates tabular format of fetched products to be pushed on the DOM
 */
function createTabProducts(json)
{
    let rif = document.querySelector('.row-item-fetch');
    for(let i = 0; i < json.data.length; ++i)
    {
        let head_fetch = document.createElement('div');
        head_fetch.className = 'head-fetch';

        let text_1 = document.createElement('div');
        text_1.className = 'text-1-fetch';

        let textNode = document.createTextNode(json.data[i].SKU);
        text_1.appendChild(textNode);

        head_fetch.appendChild(text_1);
        head_fetch.classList.add('fadeIn');
        rif.appendChild(head_fetch);
    }
}

/**
 * Creates tabular format of fetched products to be pushed on the DOM
 */
function createTabProducts_woo(json)
{
    let rif = document.querySelector('.row-item-fetch');
    for(let i = 0; i < json.body.length; ++i)
    {
        let head_fetch = document.createElement('div');
        head_fetch.className = 'head-fetch';

        let text_1 = document.createElement('div');
        text_1.className = 'text-1-fetch';

        let textNode = document.createTextNode(json.body[i].SKU);
        text_1.appendChild(textNode);

        head_fetch.appendChild(text_1);
        head_fetch.classList.add('fadeIn');
        rif.appendChild(head_fetch);
    }
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

setTimeout(()=>
{
    $(document).ready(()=>
    {
        cls_btn = document.getElementsByClassName("condition-cls-btn");
        for(let i = 0; i < cls_btn.length; ++i)
        {
            cls_btn[i].addEventListener('click', ()=>
            {
                cls_btn[i].onclick = Init_function_cond_del_ns(cls_btn[i]);
            });
        }
    });
}, 1500);

setTimeout(()=>
{
    $('.RemoveBtn').click(function(event)
    {
        if(!confirm('Are you sure you want to continue ?'))
        {
            event.preventDefault(); 
        }
        else
        {
            Init_function_usz_del(document.querySelector('.RemoveBtn'));
        }
    });
}, 1000);

setTimeout(()=>
{
    $('.Del-prod-btn').click(function(event)
    {
        if(!confirm('Are you sure you want to continue ?'))
        {
            event.preventDefault(); 
        }
        else
        {
            Init_function_prod_del();
        }
    });
}, 1000);
