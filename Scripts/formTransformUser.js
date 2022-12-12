const postUser = async function(url)
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
    createMessage(json);
    //create html element displaying success/failure
}

//transform the url
//adds the active field (set on checkbox)
function transform()
{
    let url = this.id;
    let active = this.parentElement.parentElement.firstChild.childNodes[0].checked;
    url = url + '&active=' + active;
    postUser(url);
}

//creates html message and appends to body
//result can be true or false
function createMessage(result)
{
    let button = document.createElement('button');
    let text = '';
    button.className = 'htmlMessage-success';
    text = document.createTextNode('User updated successfully');
    button.appendChild(text);

    document.querySelector('.sideNavBar').appendChild(button);

    setTimeout(()=>
    {
        button.classList.add('fade-out');
        setTimeout(()=>
        {
            button.remove();
        }, 1200);
    }, 2000);
}