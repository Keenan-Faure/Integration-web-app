function createUserTable(json)
{
    console.log(json.length);
    let userTable = document.createElement('div');
    userTable.className = 'userTable';
    for(let i = 0; i < json.length; ++i)
    {
        for(let j = 0; j < 2; ++j)
        {
            let tbl = document.createElement('table');
            if(j == 0)
            {
                let tr = document.createElement('tr');
                for(let z = 0; z < 4; ++z)
                {
                    let td = document.createElement('td');
                    let tdText = document.createTextNode('Notes');
                    td.appendChild(tdText);
                    tbl.appendChild(tr);
                }
                tbl.appendChild(tr);
                console.log(tbl);
            }
            else
            {
                // let tr = document.createElement('tr');
                // for(let z = 0; z < 4; ++z)
                // {
                //     let td = document.createElement('td');
                //     let tdText = document.createTextNode('Notes');
                //     td.appendChild(tdText);
                //     tr.appendChild(td);
                // }
            }
        }
    }
    // <div class='userTable'>
    //     <table>
    //         <tr>
    //             <td>Active</td>
    //             <td>UserID</td>
    //             <td>Username</td>
    //             <td>Token</td>
    //         </tr>
    //         <tr>
    //             <td>
    //                 <input type='checkbox' id='vehicle1' name='vehicle1' value='Bike'>
    //             </td>
    //             <td>02</td>
    //             <td>Keenan</td>
    //             <td>WVXZZGFEKWD1SNVG8XMK5JSUBYOC898T</td>
    //         </tr>
    //     </table>
    // </div>
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


