//makes the variant tab fadeOut
$(document).ready(()=>
{
    $('#vDatad').click(()=>
    {
        $('#variant').fadeOut(300);
        $('#connector').fadeOut(300);
        $('#general').fadeIn(300);
    });
});

//makes the general tab fadeOut
$(document).ready(()=>
{
    $('#gData').click(()=>
    {
        $('#general').fadeOut(300);
        $('#connector').fadeOut(300);
        $('#variant').fadeIn(300);
    });
});

$(document).ready(()=>
{
    $('#cData').click(()=>
    {
        $('#general').fadeOut(300);
        $('#variant').fadeOut(300);
        $('#connector').fadeIn(300);
    });
});

//makes the image fade in After 1.5 seconds
$(document).ready(()=>
{
    setTimeout(()=>
    {
        $('.backgroundtwo').fadeTo(1500, 1);
    }, 2000);
});

$(document).ready(()=>
{
    setTimeout(()=>
    {
        $('.containerNew').fadeTo(500, 1);
    }, 500);
});

$(document).ready(()=>
{
    setTimeout(()=>
    {
        req(document.querySelector('.s').innerHTML);
    }, 200);
});

//fetch for ID's
function createURL(sku)
{
    arrayUrl = (document.URL).split('/');
    url = 'http://' + arrayUrl[2] + '/' + 'endpoints/endpoints.php?func=get_ids&sku=' + sku;
    return url;
}
const req = async function(sku) 
{
    let url = createURL(sku);
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
        addConnectorDetails(json.body_1.result[0].P_ID, json.body_1.result[0].ID, json.body.result[0].Pushed);
        populateAuditTrail(json.body_1.result[0].Users, json.body_1.result[0].Audit_Date);
    }
}

//function to populate the ID's values
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



