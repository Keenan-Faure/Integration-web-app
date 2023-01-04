// create three methods for each request type
// GET, POST, PUT

//Initiator functions only to be used if the session token is required
//eg. InitUpdateLogs() -> requests session information to connect to the database

/**
 * Description: Initiates the request to retrieve the session information 
 * Second Description: Updates Logs
 * Parameter: None
 * Result: None
 */
function Init_function_srq()
{
    req('', 'session', 'c-m', 'putLogs', this.id, 'id');
}

/**
 * Description: Initiates the request to retrieve the session information then updates User
 * Second Descrption: Updates Users
 * Parameter: None
 * Result: None
 */
function Init_function_srq_pu()
{
    let active = this.parentElement.parentElement.firstChild.childNodes[0].checked;
    req('', 'session', 'c-m', 'putUsers', this.id, 'id', active, 'active');
}

/**
 * Description: Initial request which retrieves session token
 * @param {string} token - session token of current user
 * @param {string} param - Decides what url will be used in the first request
 * @param {string} final - The final function that will be called to make changes to the DOM
 * @param {string} urlConfig - Decides how the url endpoint will be created for the next() function request
 * @param {string} reqParam - Parameter value that will be appended in endpoint
 * @param {string} reqParamK - Parameter key that will be appended in endpoint
 */
const req = async function(token = '', param, final, urlConfig, reqParam='', reqParamK='', reqParam_2='', reqParamK_2='')
{
    let url = createURL(token, param);
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
    if(json.return != false)
    {
        reqEndpoint(json, final, urlConfig, reqParam, reqParamK, reqParam_2, reqParamK_2);
    }
}

const reqEndpoint = async function(json, final, urlConfig, reqParameter, reqParamK, reqParam_2, reqParamK_2)
{
    let url = createURL(json.token, urlConfig);
    url = appendParams(url, reqParameter, reqParamK, reqParam_2, reqParamK_2);
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
    }
}
