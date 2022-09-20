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
    function addProduct($product, $source)
    {
        if(isset($product))
        {
            $Product = new \stdClass();

            //creates the product not the array called system_products in the request
            $Product = new \stdClass();
            $Product->source = new \stdClass();
            $Product->source->source_id = $source->id;
            $Product->source->product_active = $product->Active; //hard coded to be true for now
            $Product->source->source_product_code = $product->Group_Code;
            $Product->source->sync_token = $source->sync_token;
            $Product->source->fetch_token = 0;
            $Product->product = new \stdClass();
            $Product->product->options = $this->addOptions($product);
            $Product->product->body_html = htmlspecialchars_decode($product->Description); //decodes it 
            $Product->product->collection = $product->Category;
            $Product->product->product_type = $product->Product_Type;
            $Product->product->tags = null;
            $Product->product->title = $product->Title;
            $Product->product->vendor = $product->Brand;
            $Product->product->variants = new \stdClass();
            $Product->product->variants->source_variant_code = $product->Variant_Code;
            $Product->product->variants->sku = $product->SKU;
            $Product->product->variants->barcode = $product->Barcode;
            $Product->product->variants->qty = null;
            $Product->product->variants->qty_availability = $this->addQty($product);
            $Product->product->variants->price = null;
            $Product->product->variants->price_tiers = $this->addPrices($product);
            $Product->product->variants->inventory_management = false;
            $Product->product->variants->grams = $product->Weight;
            $optionContainer = $this->addOptionValues($product, $Product->product->options);
            for($i = 0; $i < sizeof($optionContainer); ++$i)
            {
                $Product->product->variants->option1 = $optionContainer[$i];
            }
            $Product->product->meta = $this->addMeta($product);
            return $Product;
        }
        return null;
    }
    //
    function addOptions($product)
    {
        $options = array();
        if($product->Option_1_Name != null && $product->Option_1_Value != null)
        {
            $optionArray = new \stdClass();
            $optionArray->name = $product->Option_1_Name;
            $optionArray->position = sizeof($options) + 1;
            array_push($options, $optionArray);
            if($product->Option_2_Name != null && $product->Option_2_Value != null)
            {
                $optionArray->name = $product->Option_2_Name;
                $optionArray->position = sizeof($options) + 1;
                array_push($options, $optionArray);
            }
        }
        return $options;
    }
    function addQty($product)
    {
        $qty = array();
        if($product->CapeTown_Warehouse != null)
        {
            $qty_available = new \stdClass();
            $qty_available->description = 'CapeTown_Warehouse';
            $qty_available->qty = $product->CapeTown_Warehouse;
            array_push($qty, $qty_available);
        }
        return $qty;
    }

    function addPrices($product)
    {
        $price = array();
        if($product->ComparePrice != null)
        {
            $priceTier = new \stdClass();
            $priceTier->tier = 'Cost Price';
            $priceTier->price = $product->ComparePrice;
            array_push($price, $priceTier);
        }
        if($product->SellingPrice != null)
        {
            $priceTier = new \stdClass();
            $priceTier->tier = 'Selling Price';
            $priceTier->price = $product->SellingPrice;
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
                if($options[$i]->name != null)
                {
                    array_push($array, $product->Option_1_Value);
                }
                continue;
            }
            if($i == 1)
            {
                if($options[$i]->name != null)
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
        if($product->Meta_1 != null)
        {
            $metaOption = new \stdClass();
            $metaOption->key = 'Meta_1';
            $metaOption->value = $product->Meta_1;
            array_push($meta, $metaOption);
        }
        if($product->Meta_2 != null)
        {
            $metaOption = new \stdClass();
            $metaOption->key = 'Meta_2';
            $metaOption->value = $product->Meta_2;
            array_push($meta, $metaOption);
        }
        if($product->Meta_3 != null)
        {
            $metaOption = new \stdClass();
            $metaOption->key = 'Meta_3';
            $metaOption->value = $product->Meta_3;
            array_push($meta, $metaOption);
        }
        return $meta;
    }
    function push($products, $source, $token, $username, $password)
    {
        //uses json object retrieved from $products

        $request = json_encode($products);

        //url to send request
        $url = 'https://app.stock2shop.com/v1/products/queue?token=' . $token . '&source_id=' . $source->id;
        return $this->cURLRequest($request, $url, $username, $password);
    }
}
?>