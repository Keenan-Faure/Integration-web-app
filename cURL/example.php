<?php

include('cURL.php');
use cURL\CURL as curl;

//All Data here, username, password, token must come from $_SESSION variables stored inside the session.

$curl = new curl();
print_r(json_encode($curl->getSources('VS9X7THF8HKFCV2LV2F0CC2UQI67ZGJGO2DWHOOB', 'keenan.faure', 'Re_Ghoul')));

//make a condition based on the returned values httpcode and errors
//if httpcode is 200 and error is not defined and token is defined then proceed.
//else if error code is not 200 and errors is defined then display error, stop process.

/*
$data = [
    'name' => 'Premium Quality',
    'type' => 'simple',
    'regular_price' => '21.99',
    'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
    'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
    'categories' => [
        [
            'id' => 9
        ],
        [
            'id' => 14
        ]
    ],
    'images' => [
        [
            'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
        ],
        [
            'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
        ]
    ]
];

$request = new \stdClass();
$request->name = "premium Quality";
$request->type = 'simple';
$request->regular_price = '21.99';
$request->description = 'This is a description';
$request->categories = new \stdClass();
$request->categories->id = 9;
$request->categories->id = 14;
$request->images = new \stdClass();
$request->images->src = 'This is a link';
$request->images->src = 'this is another link';
header("Content-Type: application/json");
print_r($data);
print_r(json_decode(json_encode($request), true)); // true says whether its converted into an array or stdClass
*/



?>