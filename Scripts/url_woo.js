//changes the writen value of the url
//each time the select tag is changed

url = document.getElementById('url');
document.getElementById('url').value = '';

function changeUrl(value, storename)
{
    if(value.value == 'wooAuthenticate')
    {
        urlText = 'https://' + storename + '/wc-api/v3/';
        url.value = urlText;
    }
    if(value.value == 'getCustomer')
    {

    }
}