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
    if(value.value == 'woo_updateOrder')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/orders/<id>';
        url.value = urlText;

        json = 
        {
            "order":
            {
                "status": "completed"
            }
        }
        post.value = JSON.stringify(json, null, 2);
    }
    if(value.value == 'woo_postOrder')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/orders';
        url.value = urlText;

        json = 
        {
            "order":
            {
                "id": 6670,
                "order_number": "6670",
                "order_key": "wc_order_dmWCQlzgWvaJR",
                "created_at": "2022-11-02T13:33:41Z",
                "updated_at": "2022-11-02T13:35:47Z",
                "completed_at": "1970-01-01T00:00:00Z",
                "status": "pending",
                "currency": "ZAR",
                "total": "1150.00",
                "subtotal": "1000.00",
                "total_line_items_quantity": 2,
                "total_tax": "150.00",
                "total_shipping": "0.00",
                "cart_tax": "150.00",
                "shipping_tax": "0.00",
                "total_discount": "0.00",
                "shipping_methods": "",
                "payment_details": {
                  "method_id": "",
                  "method_title": "",
                  "paid": true
                },
                "billing_address": {
                  "first_name": "Keenan",
                  "last_name": "Faure",
                  "company": "Easy",
                  "address_1": "14 Tracy Close",
                  "address_2": "",
                  "city": "Cape Town",
                  "state": "WC",
                  "postcode": "7785",
                  "country": "ZA",
                  "email": "keenan@stock2shop.com",
                  "phone": ""
                },
                "shipping_address": {
                  "first_name": "Keenan",
                  "last_name": "Faure",
                  "company": "Easy",
                  "address_1": "14 Tracy Close",
                  "address_2": "",
                  "city": "Cape Town",
                  "state": "WC",
                  "postcode": "7785",
                  "country": "ZA"
                },
                "note": "",
                "customer_ip": "",
                "customer_user_agent": "",
                "customer_id": 10,
                "view_order_url": "https://s2s.ucc.co.za/my-account/view-order/6662/",
                "line_items": [
                  {
                    "id": 256,
                    "subtotal": "-173.91",
                    "subtotal_tax": "-26.09",
                    "total": "-173.91",
                    "total_tax": "-26.09",
                    "price": "-173.91",
                    "quantity": 1,
                    "tax_class": "",
                    "name": "Genshin bundle",
                    "product_id": 6576,
                    "sku": "",
                    "meta": [
                      
                    ]
                  },
                  {
                    "id": 257,
                    "subtotal": "1173.91",
                    "subtotal_tax": "176.09",
                    "total": "1173.91",
                    "total_tax": "176.09",
                    "price": "1173.91",
                    "quantity": 1,
                    "tax_class": "",
                    "name": "Ballad in Goblets - Venti",
                    "product_id": 6655,
                    "sku": "GenImp-V-AA",
                    "meta": [
                      
                    ]
                  }
                ],
                "shipping_lines": [
                  
                ],
                "tax_lines": [
                  {
                    "id": 258,
                    "rate_id": 1,
                    "code": "ZA-VAT-1",
                    "title": "VAT",
                    "total": "150.00",
                    "compound": false
                  }
                ],
                "fee_lines": [
                  
                ],
                "coupon_lines": [
                  
                ],
                "customer": {
                  "id": 10,
                  "created_at": "2022-04-07T07:40:24Z",
                  "last_update": "2022-09-26T07:24:46Z",
                  "email": "keenan@stock2shop.com",
                  "first_name": "Keenan",
                  "last_name": "Faure",
                  "username": "keenan",
                  "role": "administrator",
                  "last_order_id": 6662,
                  "last_order_date": "2022-11-02T13:33:41Z",
                  "orders_count": 11,
                  "total_spent": "19451.25",
                  "avatar_url": "https://secure.gravatar.com/avatar/81e08af00c5dfe8fb493d09ba1163d98?s=96&d=mm&r=g",
                  "billing_address": {
                    "first_name": "Keenan",
                    "last_name": "Faure",
                    "company": "Easy",
                    "address_1": "14 Tracy Close",
                    "address_2": "",
                    "city": "Cape Town",
                    "state": "WC",
                    "postcode": "7785",
                    "country": "ZA",
                    "email": "keenan@stock2shop.com",
                    "phone": ""
                  },
                  "shipping_address": {
                    "first_name": "Keenan",
                    "last_name": "Faure",
                    "company": "Easy",
                    "address_1": "14 Tracy Close",
                    "address_2": "",
                    "city": "Cape Town",
                    "state": "WC",
                    "postcode": "7785",
                    "country": "ZA"
                  }
                }
              }
        }
        post.value = JSON.stringify(json, null, 2);
    }
    if(value.value == 'woo_getOrderNote')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/orders/<id>/notes/<note_id>';
        url.value = urlText;
    }
    if(value.value == 'woo_getOrderNote_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/orders/<id>/notes';
        url.value = urlText;
    }
    if(value.value == 'woo_deleteOrderNote')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/orders/<id>/notes/<note_id>';
        url.value = urlText;
    }
    if(value.value == 'woo_postOrderNote')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/orders/<id>/notes';
        url.value = urlText;

        json = 
        {
            "order_note": 
            {
                "note": "3, 2, 1 Make some noise!!"
            }
          }
        post.value = JSON.stringify(json, null, 2);
    }
    if(value.value == 'woo_getProduct')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_getProductBySKU')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products?filter[sku]=<sku>';
        url.value = urlText;
    }
    if(value.value == 'woo_getProduct_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products';
        url.value = urlText;
    }
    if(value.value == 'woo_deleteProduct')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_updateProduct')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/products/<id>';
        url.value = urlText;

        json = 
        {
            "product":
            {
                "regular_price": "24.54"
            }
        }
        post.value = JSON.stringify(json, null, 2);
    }
    if(value.value == 'woo_createProduct')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/products';
        url.value = urlText;

        json = 
        {
            "product": 
            {
                "name": "Premium Quality",
                "type": "simple",
                "regular_price": "21.99",
                "description": "I am a long Description",
                "short_description": "I am a short description",
                "categories": 
                [
                    {
                        "id": 9
                    },
                    {
                        "id": 14
                    }
                ],
                "images": 
                [
                    {
                        "src": "http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg"
                    },
                    {
                        "src": "http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg"
                    }
                ]
            }
        }
        post.value = JSON.stringify(json, null, 2);
    }

    if(value.value == 'woo_getProductVariation')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/<product_id>/variations/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_getProductVariation_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/<product_id>/variations';
        url.value = urlText;
    }
    if(value.value == 'woo_deleteProductVariation')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/<product_id>/variations/<id>';
        url.value = urlText;
    }
    if(value.value == 'woo_updateProductVariation')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/products/<product_id>/variations/<id>';
        url.value = urlText;

        json = 
        {
            "product":
            {
                "regular_price": "24.54"
            }
        }
        post.value = JSON.stringify(json, null, 2);
    }
    if(value.value == 'woo_postProductVariation')
    {
        hideShowData($('#post'), 'show');
        hideShowData($('#rmv1'), 'hide');
        hideShowData($('#rmv2'), 'hide');
        urlText = 'https://' + storename + '/wc-api/v3/products/<product_id>/variations';
        url.value = urlText;

        json = 
        {
            "product": 
            {
                "regular_price": "9.00",
                "image": 
                {
                    "id": 423
                },
                "attributes": 
                [{
                    "id": 6,
                    "option": "Black"
                }]
            }
        }
        post.value = JSON.stringify(json, null, 2);
    }
    if(value.value == 'woo_getProductAttribute_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/attributes';
        url.value = urlText;
    }
    if(value.value == 'woo_getProductCategories_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/categories';
        url.value = urlText;
    }
    if(value.value == 'woo_getProductShipClas_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/products/shipping_classes';
        url.value = urlText;
    }
    if(value.value == 'woo_getWebhook_l')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/webhooks';
        url.value = urlText;
    }
    if(value.value == 'woo_getSystemStatus')
    {
        hideShowData($('#post'), 'hide');
        hideShowData($('#rmv1'), 'show');
        hideShowData($('#rmv2'), 'show');
        urlText = 'https://' + storename + '/wc-api/v3/system_status';
        url.value = urlText;
    }
 
}

document.getElementById('form').addEventListener('submit', function(event)
{
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