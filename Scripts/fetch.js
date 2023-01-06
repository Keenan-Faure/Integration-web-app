/**
 * @Description Initiates the request to retrieve the session information - Updates Logs
 * @Parameters None
 * @Returns None
 */
function Init_function_srq()
{
    req('', 'session', 'c-m', 'putLogs', '', this.id, 'id');
}

/**
 * @Description Initiates the request to retrieve the session information - Updates Users
 * @Parameters None
 * @Returns None
 */
function Init_function_srq_pu()
{
    let active = this.parentElement.parentElement.firstChild.childNodes[0].checked;
    req('', 'session', 'c-m', 'putUsers', '', this.id, 'id', active, 'active');
}

/**
 * @Description Initiates the request to retrieve the session information - Loads connector details
 * @Parameters None
 * @Returns None
 */
function Init_function_sku_p()
{
    setTimeout(()=>
    {
        let sku = document.getElementsByClassName('s');
        if(sku.length != 0)
        {
            req('', 'session', 'p-c-d', 'getIDs', '',sku[0].innerHTML, 'sku');
        }
    }, 200);
}

/**
 * @Description Initiates the request to retrieve the session information - Pushes data to Woocommerce
 * @Parameters None
 * @Returns None
 */
function Init_function_sku_woo()
{
    req('', 'getSKU', '', 'pushWoo', 'Woocommerce', 'woo', 'conn');
}

/**
 * @Description Initiates the request to retrieve the session information - Pushes data to Stock2Shop
 * @Parameters None
 * @Returns None
 */
function Init_function_sku_s2s()
{
    req('', 'getSKU', '', 'pushS2S', 'Stock2Shop','s2s', 'conn');
}

/**
 * @Description Inserts Conditions into the database
 * @param {string} element Element being clicked
 * @Returns None
 */
function Init_function_cond_add_ns(element)
{
    if(element == '')
    {
        let string = create_cond_params(this);
        req([string, element], 'putCond_add', 'd-o', '', '', '', '');
    }
    else
    {
        let string = create_cond_params(element);
        req([string, element], 'putCond_add', 'd-o', '', '', '', '');
    }
}

/**
 * @Description Removes Conditions from the database
 * @param {string} element Element being clicked
 * @Returns None
 */
function Init_function_cond_del_ns(element='')
{
    let string = create_cond_params_del(element);
    req([string, element], 'putCond_del', 'd-o-d', '', '', '', '');
}

/**
 * @Description Initial request which retrieves session token
 * @param {string} token - session token of current user, functions with `_ns` will use token as `[string, element]`
 * @param {string} param - Decides what url will be used in the first request
 * @param {string} final - The final function that will be called to make changes to the DOM
 * @param {string} urlConfig - Decides how the url endpoint will be created for the next() function request
 * @param {string} conn - Specifies whether the request will be to a connector or not - S2S/Woo
 * @param {string} reqParam - Parameter value that will be appended in endpoint
 * @param {string} reqParamK - Parameter key that will be appended in endpoint
 */
const req = async function(token = '', param, final, urlConfig, conn='', reqParam='', reqParamK='', reqParam_2='', reqParamK_2='')
{
    let url = createURL(token, param);
    if(conn != '')
    {
        url = appendParams(url, reqParam, reqParamK, reqParam_2, reqParamK_2);
    }
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
    if(conn != '')
    {
        if(json.body.length == 0)
        {
            changeAmount("No products found to push");//sets the total amount of products to process
            reqEndpoint(json, '', urlConfig, reqParam, reqParamK, reqParam_2, reqParamK_2, conn);
        }
        else
        {
            changeAmount("0 / " + json.body.length);//sets the total amount of products to process
            reqEndpoint(json, '', urlConfig, reqParam, reqParamK, reqParam_2, reqParamK_2, conn);
        }
    }
    /**
     * the OR statement is added on because it will return both true and false return statement
     * This only applies to when the final function equals d-o/d-o-d
     */
    else if(json.return != false || final == 'd-o')
    {
        if(urlConfig != '')
        {
            reqEndpoint(json, final, urlConfig, reqParam, reqParamK, reqParam_2, reqParamK_2, conn);
        }
        else if(urlConfig == '' && final == 'd-o' || final == 'd-o-d')
        {
            if(final == 'd-o-d')
            {
                createMessage(json, 'Success');
                create_condition_dom(token, true);
            }
            else if(final == 'd-o')
            {
                createMessage(json, 'Success');
                if(json.return == true)
                {
                    create_condition_dom(token);
                }
            }
        }
    }
}

/**
 * @Description Requests data from endpoint and returns json data
 * @param {string} json - Json session data from previous request
 * @param {string} final - final function to run
 * @param {string} urlConfig - configs the endpoint's url
 * @param {string} reqParam - endpoint query parameter value
 * @param {string} reqParamK - endpoint query parameter key
 * @param {string} conn - Specifies whether the request will be to a connector or not - S2S/Woo
 */
const reqEndpoint = async function(json, final, urlConfig, reqParam, reqParamK, reqParam_2, reqParamK_2, conn)
{
    if(conn == '')
    {
        let url = createURL(json.token, urlConfig);
        url = appendParams(url, reqParam, reqParamK, reqParam_2, reqParamK_2);
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
        if(jsonResults.return != false)
        {
            if(final == 'c-m')
            {
                createMessage(jsonResults, 'Success');
            }
            else if(final == 'c-u-t')
            {
                createUserTable(jsonResults);
            }
            else if(final == 'p-c-d')
            {
                addConnectorDetails(jsonResults.body_1.result[0].P_ID, jsonResults.body_1.result[0].ID, jsonResults.body.result[0].Pushed);
                populateAuditTrail(jsonResults.body_1.result[0].Users, jsonResults.body_1.result[0].Audit_Date);
            }
        }
    }
    else if(conn != '')
    {
        //uses the json in req to make a loop
        for(let i = 0; i < json.body.length; ++i)
        {
            let url = createURL('', urlConfig);
            if(conn == 'Stock2Shop')
            {
                url = appendParams(url, json.body[i].SKU, 'sku', json.body.length, 'limit');
            }
            else if(conn == 'Woocommerce')
            {
                url = appendParams(url, json.body[i].SKU, 'sku', reqParam_2, reqParamK_2);
            }
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
            if(jsonResults.result == true)
            {
                changeAmount((i + 1) + " / " + json.body.length);//updates the process
                appendText(jsonResults.message, jsonResults.result);
            }
            else
            {
                changeAmount((i + 1) + " / " + json.body.length);//updates the process
                appendText(jsonResults.message, jsonResults.result);
            }
        }
        document.getElementById('text').innerHTML = 'Push Complete';
        document.querySelector('.container').style.backgroundImage = "url('../Images/completed.gif')";
    }
}
