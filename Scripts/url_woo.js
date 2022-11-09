//changes the writen value of the url
//each time the select tag is changed

url = document.getElementById('url');
post = document.getElementById('pst');

document.getElementById('url').value = '';
document.getElementById('pst').value = '';

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

        json = 
        {
            "customer":
            {
                "email": "keenan@stock2shop.com",
                "first_name": "Keenan",
                "last_name": "Faure",
                "username": "keenan.faure"
            }
        }
        post.value = JSON.stringify(json, null, 2);

    }
    if(value.value == 'woo_postCustomer')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/customers';
        url.value = urlText;

        json = 
        {
            "customer":
            {
                "email": "keenan@stock2shop.com",
                "first_name": "Keenan",
                "last_name": "Faure",
                "username": "keenan.faure"
            }
        }
        post.value = JSON.stringify(json, null, 2);
    }
    if(value.value == 'woo_getOrder')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/orders/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_getOrder_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/orders';
        url.value = urlText;
    }
    if(value.value == 'woo_deleteOrder')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/orders/<id>';
        url.value = urlText;
    }
 
}

document.getElementById('form').addEventListener('submit', function(event)
{
    console.log(document.querySelector('.appTitle-Woo').value);
    if(['woo_deleteCustomer', 'woo_deleteOrder', 'woo_deleteProduct'].includes(document.querySelector('.appTitle-Woo').value))
    {
        if (!confirm('Are you sure you want to proceed?'))
        {
            event.preventDefault(); 
        }
    }
});

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