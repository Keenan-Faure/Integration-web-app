<?php
namespace cURL;

Class CURL
{   
    function getUrl()
    {
        $host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
        $url = explode('/', $_SERVER['REQUEST_URI']); //needs to be defined
        $baseurl = $host;
        $delimiter = '/';
        for($i = 0; $i < sizeof($url); ++ $i)
        {
            if($url[$i] == 'MySQL-API')
            {
                return $baseurl;
            }
            else
            {
                if($i == 0)
                {
                    $baseurl = $baseurl . $url[$i];
                }
                else
                {
                    $baseurl = $baseurl . $delimiter . $url[$i];
                }
            }
        }
    }
    function get_web_page($url, $request = null, $username, $password) 
    {
        $options = array(
            CURLOPT_USERPWD => $username . ":" . $password, 
            CURLOPT_HTTPHEADER => array("Content-Type: application/json", "accept: application/json"),
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        ); 
        
        $ch = curl_init($url);

        if(isset($request))
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        }

        curl_setopt_array($ch, $options);
        $content  = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //adds the HTTP code to check if errors were found
        $content = $this->addHTTP($content, $httpcode);
        curl_close($ch);
    
        return $content;
    }
    function getSources($token, $username, $password)
    {
        //use http_build_query here to create parameters for ep
        $params = http_build_query(array('format' => 'json', 'token' => $token)); 

        $url = 'https://app.stock2shop.com/v1/sources?' . $params;
        return $this->cURLRequest(null, $url, $username, $password);

    }
    function getChannels($token, $username, $password)
    {
        //use http_build_query here to create parameters for ep
        $params = http_build_query(array('format' => 'json', 'token' => $token)); 

        $url = 'https://app.stock2shop.com/v1/channels?' . $params;
        return $this->cURLRequest(null, $url, $username, $password);
    }

    function cURLRequest($request = new \stdClass(), $url, $username, $password)
    {
        $response = $this->get_web_page($url, $request, $username, $password);
        $resArr = array();
        $resArr = json_decode($response);
        return $resArr;
    }

    function validateToken($token, $username, $password)
    {
        $url = 'https://app.stock2shop.com/v1/users/valid_token/' . $token . '?format=json';
        return $this->cURLRequest(null, $url, $username, $password);
    }

    function authenticate($username, $password)
    {
        //builds json object
        $request = new \stdClass();
        $request->system_user_auth = new \stdClass();
        $request->system_user_auth->username = $username;
        $request->system_user_auth->password = $password;
        $request = json_encode($request);

        //url to send request
        $url = 'https://app.stock2shop.com/v1/users/authenticate?format=json';
        return $this->cURLRequest($request, $url, $username, $password);
    }
    function addHTTP($content, $code)
    {
        $content = json_decode($content);
        $content->httpcode = $code;

        $content = json_encode($content);
        return $content;
    }
    function addProduct($product)
    {
        if(isset($product))
        {
            $product = new \stdClass();

            //creates the product not the array called system_products in the request
            $product = new \stdClass();
            $product->source = new \stdClass();
            $product->source->source_id = '';
            $product->source->product_active = '';
            $product->source->source_product_code = '';
            $product->source->sync_token = '';
            $product->source->fetch_token = '';
            $product->product = new \stdClass();
            $product->product->options = $this->addOptions($product);
            $product->product->body_html = '';
            $product->product->collection = '';
            $product->product->product_type = '';
            $product->product->tags = '';
            $product->product->title = '';
            $product->product->vendor = '';
            $product->product->variants = new \stdClass();
            $product->product->variants->source_variant_code = '';
            $product->product->variants->sku = '';
            $product->product->variants->barcode = '';
            $product->product->variants->qty = null;
            $product->product->variants->qty_availability = $this->addQty($product);
            $product->product->variants->price = null;
            $product->product->variants->price_tiers = $this->addPrices($product);
            $product->product->variants->inventory_management = false;
            $product->product->variants->grams = '';
            $optionContainer = $this->addOptionValues($product, $product->product->options);
            if(sizeof($optionContainer) > 0)
            {
                $product->product->variants->option1 = $optionContainer[0];
                $product->product->variants->option1 = $optionContainer[1];
            }
            $product->product->meta = $this->addMeta($product);
            return $product;
        }
        return null;
    }
    //
    function addOptions($product)
    {
        $options = array();
        if(isset($product->result->Option_1_Name) && isset($product->result->Option_1_Value))
        {
            $optionArray = new \stdClass();
            $optionArray->name = $product->result->Option_1_Name;
            $optionArray->position = sizeof($options) + 1;
            array_push($options, $optionArray);
            if(isset($product->result->Option_2_Name) && isset($product->result->Option_2_Value))
            {
                $optionArray->name = $product->result->Option_2_Name;
                $optionArray->position = sizeof($options) + 1;
                array_push($options, $optionArray);
            }
        }
        return $options;
    }
    function addQty($product)
    {
        $qty = array();
        if(isset($product->result->CapeTown_Warehouse))
        {
            $qty_available = new \stdClass();
            $qty_available->description = 'CapeTown_Warehouse';
            $qty_available->qty = $product->result->CapeTown_Warehouse;
            array_push($qty, $qty_available);
        }
        return $qty;
    }

    function addPrices($product)
    {
        $price = array();
        if(isset($product->result->CostPrice))
        {
            $priceTier = new \stdClass();
            $priceTier->tier = 'Cost Price';
            $priceTier->price = $product->result->CostPrice;
            array_push($price, $priceTier);
        }
        if(isset($product->result->SellingPrice))
        {
            $priceTier = new \stdClass();
            $priceTier->tier = 'Selling Price';
            $priceTier->price = $product->result->SellingPrice;
            array_push($price, $priceTier);
        }
        return $price;

    }

    function addOptionValues($product, $options)
    {
        $array = array();
        for($i = 0; $i < sizeof($options); $i ++)
        {
            if($i == 0)
            {
                if(isset($options[$i]->name))
                {
                    array_push($array, $product->Option_1_Value);
                }
                continue;
            }
            if($i == 1)
            {
                if(isset($options[$i]->name))
                {
                    array_push($array, $product->Option_2_Value);
                }
            }
        }
        return $array;
    }
    function addMeta($product)
    {
        $meta = array();
        if(isset($product->Meta_1))
        {
            $metaOption = new \stdClass();
            $metaOption->key = 'Meta_1';
            $metaOption->value = $product->Meta_1;
            array_push($meta, $metaOption);
        }
        if(isset($product->Meta_2))
        {
            $metaOption = new \stdClass();
            $metaOption->key = 'Meta_2';
            $metaOption->value = $product->Meta_2;
            array_push($meta, $metaOption);
        }
        if(isset($product->Meta_3))
        {
            $metaOption = new \stdClass();
            $metaOption->key = 'Meta_3';
            $metaOption->value = $product->Meta_3;
            array_push($meta, $metaOption);
        }
        return $meta;
    }
}
?>