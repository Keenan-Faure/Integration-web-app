//changes the writen value of the url
//each time the select tag is changed

url = document.getElementById('url');
document.getElementById('url').value = '';

function changeUrl(value, storename)
{
    if(value.value == 'woo_Auth')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/';
        url.value = urlText;
    }
    if(value.value == 'woo_getCustomer')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/customers/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_getCustomer_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/customers';
        url.value = urlText;
    }
    if(value.value == 'woo_deleteCustomer')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/customers/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_updateCustomer')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/customers/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_postCustomer')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/customers/<id>';
        url.value = urlText;
    }
}

//displays or hides the containers
//denpending on the value of the parameter
function hideShowData(id, display)
{
    $(document).ready(()=>
    {
        if(display == 'show')
        {
            $(id).css(
            {
                "display": "block"
            });
            $(['#cs', '#ck']).css(
                {
                    "display": "block"
                }
            );
            $(['#pst']).css(
                {
                    "display": "none"
                }
            );
        }
        else if(display == 'hide')
        {
            $(id).css(
            {
                "display": "none"
            });
            $(['#cs', '#ck']).css(
                {
                    "display": "none"
                }
            );
            $(['#pst']).css(
                {
                    "display": "block"
                }
            );
        }
    });
}