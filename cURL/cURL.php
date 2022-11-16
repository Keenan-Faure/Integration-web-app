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

    //uses cURL
    //URL is the url that we will be initiating the cURL request against
    //request is the data of the cURL in stdClass (object) notation
    //username and password acts as the creentials
    function get_web_page($url, $request = null, $username = '', $password = '', $customReq = null) 
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
        
        //Initializes a new session and return a cURL handle for use
        //uses the URL in function parameter
        $ch = curl_init($url);

        if(isset($request))
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        }

        //sets the delete as a customRequest
        //if it is anything but delete it will not be set
        if(isset($customReq))
        {
            if($customReq == 'delete')
            {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            }
            else if($customReq == 'put')
            {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            }
            else if($customReq == 'post')
            {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            }
        }

        curl_setopt_array($ch, $options);
        $content  = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //adds the HTTP code to check if errors were found
        $content = $this->addHTTP($content, $httpcode);
        curl_close($ch);
    
        return $content;
    }

    /*
    +--------------------------------+
    | Function call: Stock2Shop      |
    | getSources() -> cURL request() |
    | -> get_web_page() -> addHTTP() |
    +--------------------------------+
    */

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

    //Initiates the Curl Response
    function cURLRequest($request = new \stdClass(), $url = '', $username = '', $password = '')
    {
        $response = $this->get_web_page($url, $request, $username, $password);
        $resArr = array();
        $resArr = json_decode($response);
        return $resArr;
    }

    //adds the HTTP header to the content
    function addHTTP($content, $code)
    {
        $content = json_decode($content);
        if(!isset($content))
        {
            $var = new \stdClass();
            $var->message = 'An Error occured while trying to connect to the URL';
            $var->http_code = $code;
            return json_encode($var);
        }
        $content->httpcode = $code;

        $content = json_encode($content);
        return $content;
    }

    function push($products, $source, $token, $username, $password)
    {
        //uses json object retrieved from $products

        $request = json_encode($products);

        //url to send request
        $url = 'https://app.stock2shop.com/v1/products/queue?token=' . $token . '&source_id=' . $source->id;
        return $this->cURLRequest($request, $url, $username, $password);
    }

    //creates the query considering the conditions 
    //defined inside the Conditions table
    //and returns query
    function createQuery($conditions)
    {
        $duplicates = $this->findDuplicates(json_decode(json_encode($conditions->result), true));
        $duplicateValues = array();
        $query = "SELECT * FROM Inventory WHERE ";
        $condition = $conditions->result;
        $additional = '';
        $Clause = '';
        if(sizeof($condition) == 0)
        {
            return "SELECT * FROM Inventory";
        }
        else
        {
            $conditionIndex = 0;
            for($i = 0; $i < sizeof($condition); ++$i)
            {
                if(in_array($condition[$i]->DataValue, $duplicates))
                {
                    $duplicateValues[$conditionIndex] = $condition[$i]->Value;
                    $conditionIndex = $conditionIndex + 1;
                    continue;
                }
                if(($i - $conditionIndex) > 0)
                {
                    $Clause = $Clause . ' && ';
                }
                $Clause = $condition[$i]->DataValue . $condition[$i]->Conditions . "'" . $condition[$i]->Value . "'"; 
            }
            //When the above is done
            //Then it adds the query: duplicate in ('duplicatevalue[0]', 'duplicatevalue[1]');
            for($j = 0; $j < sizeof($duplicates); ++$j)
            {
                if($j > 0)
                {
                    $additional = $additional . ' && ';
                }
                if($Clause == "")
                {
                    $additional = $duplicates[$j] . " IN ";
                }
                else
                {
                    $additional = " && " . $duplicates[$j] . " IN ";
                }
                $values = '';
                for($z = 0; $z < sizeof($duplicateValues); ++$z)
                {
                    if($z > 0)
                    {
                        $values = ',' . $values;
                    }
                    $values = "'" . $duplicateValues[$z] . "'" . $values;
                }
                $additional = $additional . '(' . $values . ')';
            }
        }
        $query = $query . $Clause . $additional;
        return $query;
    }

    function findDuplicates($conditionArray)
    {
        $repeated = array();
        $output = array();
        for($i = 0; $i < sizeof($conditionArray); ++$i)
        {
            $repeated[$i] = $conditionArray[$i]['DataValue'];
        }
        $repeated = array_count_values($repeated);
        foreach($repeated as $key => $value)
        {
            $i = 0;
            if($value > 1)
            {
                $output[$i] = $key;
                ++$i;
            }
        }
        return $output;
    }

    function addProduct($product, $source, $_settings)
    {
        $array = [
            //source
            '$source->id' => $source->id,
            '$product->Active' => $product->Active,
            '$source->product_code'=> $product->Group_Code,
            '$source->sync_token'=> $source->sync_token,
            '$source->fetch_token'=> 0,

            //product
            '$product->Title' => $product->Title,
            '$product->Description' => $product->Description,
            '$product->Category' => $product->Category,
            '$product->Product_Type' => $product->Product_Type,
            '$product->Brand' => $product->Brand,
            '$product->SKU' => $product->SKU,
            '$product->Group_Code' => $product->Group_Code,
            '$product->Variant_Code' => $product->Variant_Code,
            '$product->Barcode' => $product->Barcode,
            '$product->Weight' => $product->Weight,
            '$product->ComparePrice' => $product->ComparePrice,
            '$product->SellingPrice' => $product->SellingPrice,
            '$product->CapeTown_Warehouse' => $product->CapeTown_Warehouse,
            '$product->Option_1_Name' => $product->Option_1_Name,
            '$product->Option_1_Value' => $product->Option_1_Value,
            '$product->Option_2_Name' => $product->Option_2_Name,
            '$product->Option_2_Value' => $product->Option_2_Value,
            '$product->Meta_1' => $product->Meta_1,
            '$product->Meta_2' => $product->Meta_2,
            '$product->Meta_3' => $product->Meta_3
        ];

        if(isset($product))
        {
            if($_settings->S2S_settings->s2s_delete_products == 'false')
            {
                if($product->Active == 'false')
                {
                    return null;
                }
            }

            if(isset($product))
            {
                if($_settings->S2S_settings->s2s_use_product_map == 'true')
                {
                    $product_map = $_settings->S2S_settings->s2s_product_map;
                    if($product_map == null)
                    {
                        return null;
                    }
                    else
                    {
                        $product_map_array = json_decode($product_map, true);
                        foreach($product_map_array as $key => $value)
                        {
                            if(is_array($value))
                            {
                                foreach($value as $subKey => $subValue)
                                {
                                    if(is_array($subValue))
                                    {
                                        foreach($subValue as $root => $rootValue)
                                        {
                                            if(is_array($rootValue))
                                            {
                                                foreach($rootValue as $raw => $rawValue)
                                                {
                                                    if(is_array($rawValue))
                                                    {
                                                        foreach($rawValue as $ori => $oriValue)
                                                        {
                                                            if((array_search($oriValue, $product_map_array[$key][$subKey][$root][$raw]) != false) && $oriValue != null && isset($array[$oriValue]))
                                                            {
                                                                $product_map_array[$key][$subKey][$root][$raw][$ori] = (str_replace($oriValue,$array["$oriValue"],$product_map_array[$key][$subKey][$root][$raw][$ori]));
                                                            }
                                                            else
                                                            {
                                                                if(!isset($array[$oriValue]) && array_key_exists($oriValue, $array))
                                                                {
                                                                    $product_map_array[$key][$subKey][$root][$raw][$ori] = null;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if((array_search($rawValue, $product_map_array[$key][$subKey][$root]) != false) && $rawValue != null && isset($array[$rawValue]))
                                                        {
                                                            $product_map_array[$key][$subKey][$root][$raw] = (str_replace($rawValue,$array["$rawValue"],$product_map_array[$key][$subKey][$root][$raw]));
                                                        }
                                                        else
                                                        {
                                                            if(!isset($array[$rawValue]) && array_key_exists($rawValue, $array))
                                                            {
                                                                $product_map_array[$key][$subKey][$root][$raw] = null;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                if((array_search($rootValue, $product_map_array[$key][$subKey]) != false) && $rootValue != null && isset($array[$rootValue]))
                                                {
                                                    $product_map_array[$key][$subKey][$root] = (str_replace($rootValue,$array["$rootValue"],$product_map_array[$key][$subKey][$root]));
                                                }
                                                else
                                                {
                                                    if(!isset($array[$rootValue]) && array_key_exists($rootValue, $array))
                                                    {
                                                        $product_map_array[$key][$subKey][$root] = null;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if((array_search($subValue, $product_map_array[$key]) != false) && $subValue != null && isset($array[$subValue]))
                                        {
                                            $product_map_array[$key][$subKey] = (str_replace($subValue,$array["$subValue"],$product_map_array[$key][$subKey]));
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $product_map_array[$key] = (str_replace($value,$array["$value"],$product_map_array[$key]));
                            }
                        }
                        //returns it in StdClass Format
                        $product = new \stdClass();
                        $product = json_decode(json_encode($product_map_array));
                        return $product;
                    }
                }
                else
                {
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
                    $Product->product->body_html = htmlspecialchars_decode(stripslashes($product->Description)); //decodes it 
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
            }
        }
        return null;
    }

    // Helper Functions for the internal product map

    //Adds options to products
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
            $priceTier->tier = 'Compare To Price';
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

    //checks if a product already exists on Woocommerce
    // returns true if it does exist
    // false if it does not
    // otherwise it will return and stdClass, false => message
    function check_woo_sku($sku)
    {
        if(isset($_SESSION['woo_settings']))
        {
            //gets settings from php file
            $wooSettings = $_SESSION['woo_settings'];
            $storeName = $wooSettings->Woocommerce_Store->store_name;
            $url = 'https://' . $storeName. '/wc-api/v3/products?filter[sku]=' . $sku;
            $ck = $wooSettings->Woocommerce_Store->consumer_key;
            $cs = $wooSettings->Woocommerce_Store->consumer_secret;

            $result = $this->get_web_page($url, null, $ck, $cs);
            if($result == null)
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = 'Incorrect store name';
                return $variable;
            }
            if(json_decode($result)->products == null)
            {
                return false;
            }
            else if(json_decode($result)->products != null)
            {
                return true;
            }
            else
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = 'Malformed JSON received from Woocommerce';
                return $variable;
            }
        }
        else
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = 'No session detected';
            return $variable;
        }
    }

    /*
    +--------------------------------+
    | Function call: Woocommerce     |
    | formValue() -> cURL request()  |
    | -> get_web_page() -> addHTTP() |
    +--------------------------------+
    */

    //displays the Woocommerce API details of the store
    function Auth()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Incorrect store name';
            return $variable;
        }
        return $result;
    }

    //GET customers from Woocommerce by ID
    function getCustomer()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //returns a list of customers from Woocommerce
    function getCustomer_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //removes the respective customer on Woocommerce
    function deleteCustomer()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs'], 'delete');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //updates the customer on Woocommerce, overwrites values using $post
    function updateCustomer()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'put');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //creates new customer on Woocommerce
    function postCustomer()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'post');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //returns an order from Woocommerce
    function getOrder()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //returns a list of orders from Woocommerce
    function getOrder_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //deletes an order on Woocommerce
    function deleteOrder()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs'], 'delete');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }
    
    //updates an order on Woocommerce
    function updateOrder()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'put');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //updates an order on Woocommerce
    function postOrder()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'post');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //updates an order's notes on Woocommerce
    function postOrderNote()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'post');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets an order's notes on Woocommerce
    function getOrderNote()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a list of an order's notes on Woocommerce
    function getOrderNote_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //deletes an order's notes on Woocommerce
    function deleteOrderNote()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs'], 'delete');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a product from Woocommerce
    function getProduct()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a product from Woocommerce
    function getProductBySKU()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }


    //gets a list of products from Woocommerce
    function getProduct_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //deletes a products on Woocommerce
    function deleteProduct()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs'], 'delete');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //updates a products on Woocommerce
    function updateProduct()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'put');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //updates a products on Woocommerce
    function createProduct()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'post');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a product from Woocommerce
    function getProductVariation()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a list of products from Woocommerce
    function getProductVariation_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //deletes a products on Woocommerce
    function deleteProductVariation()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs'], 'delete');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //updates a products on Woocommerce
    function updateProductVariation()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'put');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //updates a products on Woocommerce
    function createProductVariation()
    {
        $post = $_POST['pst'];
        $result = $this->get_web_page($_POST['url'], $post, $_POST['ck'], $_POST['cs'], 'post');
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a list of products Attributes from Woocommerce
    function getProductAttribute_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a list of products Categories from Woocommerce
    function getProductCategories_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a list of shipping classes on Woocommerce
    function getProductShipClas_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets a list of webhooks on Woocommerce
    function getWebhook_l()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //gets the system status of the server woocommerce is found on
    function getSystemStatus()
    {
        $result = $this->get_web_page($_POST['url'], null, $_POST['ck'], $_POST['cs']);
        if($result == null)
        {
            $variable = new \stdClass();
            $variable->message = 'Error occured';
            return $variable;
        }
        return $result;
    }

    //creates WoocommerceProductMap
    //internal map uses stdClasses
    //external map uses map inside config
    function woo_addProduct($product, $_wooSettings, $wooExist, $connection)
    {
        $array = [
            //product
            '$product->Title' => $product->Title,
            '$product->Type' => $product->Type,
            '$_wooSettings->Woocommerce_Settings->woo_product_status' => $_wooSettings->Woocommerce_Settings->woo_product_status,
            '$product->Description' => $product->Description,
            '$product->Brand' => $product->Brand,
            '$product->SKU' => $product->SKU,
            '$product->Weight' => $product->Weight,
            '$product->ComparePrice' => $product->ComparePrice,
            '$product->SellingPrice' => $product->SellingPrice,
            '$product->CapeTown_Warehouse' => $product->CapeTown_Warehouse,
            '$product->Option_1_Name' => $product->Option_1_Name,
            '$product->Option_1_Value' => $product->Option_1_Value,
            '$product->Option_2_Name' => $product->Option_2_Name,
            '$product->Option_2_Value' => $product->Option_2_Value,
            '$product->Meta_1' => $product->Meta_1,
            '$product->Meta_3' => $product->Meta_3
        ];

        if(isset($product))
        {
            if($_wooSettings->Woocommerce_Settings->woo_delete_products == 'false')
            {
                if($product->Active == 'false')
                {
                    return null;
                }
            }

            if(isset($product))
            {
                if($_wooSettings->Woocommerce_Settings->woo_use_product_map == 'true')
                {
                    $product_map = $_wooSettings->Woocommerce_Settings->woo_product_map;
                    if($product_map == null)
                    {
                        return null;
                    }
                    else
                    {
                        $product_map_array = json_decode($product_map, true);
                        foreach($product_map_array as $key => $value)
                        {
                            if(is_array($value))
                            {
                                foreach($value as $subKey => $subValue)
                                {
                                    if(is_array($subValue))
                                    {
                                        foreach($subValue as $root => $rootValue)
                                        {
                                            if(is_array($rootValue))
                                            {
                                                foreach($rootValue as $raw => $rawValue)
                                                {
                                                    if(is_array($rawValue))
                                                    {
                                                        foreach($rawValue as $ori => $oriValue)
                                                        {
                                                            if(is_array($oriValue))
                                                            {
                                                                foreach($oriValue as $haji => $hajiValue)
                                                                {
                                                                    if((in_array($hajiValue, $product_map_array[$key][$subKey][$root][$raw][$ori]) != false) && $hajiValue != null && isset($array[$hajiValue]))
                                                                    {
                                                                        $product_map_array[$key][$subKey][$root][$raw][$ori][$haji] = (str_replace($hajiValue,$array["$hajiValue"],$product_map_array[$key][$subKey][$root][$raw][$ori][$haji]));
                                                                    }
                                                                    else if((array_search($hajiValue, $product_map_array[$key][$subKey][$root][$raw][$ori]) != false) && $hajiValue != null && isset($array[$hajiValue]))
                                                                    {
                                                                        $product_map_array[$key][$subKey][$root][$raw][$ori][$haji] = (str_replace($hajiValue,$array["$hajiValue"],$product_map_array[$key][$subKey][$root][$raw][$ori][$haji]));
                                                                    }
                                                                    else
                                                                    {
                                                                        if(!isset($array[$hajiValue]) && array_key_exists($hajiValue, $array))
                                                                        {
                                                                            $product_map_array[$key][$subKey][$root][$raw][$ori][$haji] = null;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            else
                                                            {
                                                                if((in_array($oriValue, $product_map_array[$key][$subKey][$root][$raw]) != false) && $oriValue != null && isset($array[$oriValue]))
                                                                {
                                                                    $product_map_array[$key][$subKey][$root][$raw][$ori] = (str_replace($oriValue,$array["$oriValue"],$product_map_array[$key][$subKey][$root][$raw][$ori]));
                                                                }
                                                                else if((array_search($oriValue, $product_map_array[$key][$subKey][$root][$raw]) != false) && $oriValue != null && isset($array[$oriValue]))
                                                                {
                                                                    $product_map_array[$key][$subKey][$root][$raw][$ori] = (str_replace($oriValue,$array["$oriValue"],$product_map_array[$key][$subKey][$root][$raw][$ori]));
                                                                }
                                                                else
                                                                {
                                                                    if(!isset($array[$oriValue]) && array_key_exists($oriValue, $array))
                                                                    {
                                                                        $product_map_array[$key][$subKey][$root][$raw][$ori] = null;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if((in_array($rawValue, $product_map_array[$key][$subKey][$root]) != false) && $rawValue != null && isset($array[$rawValue]))
                                                        {
                                                            $product_map_array[$key][$subKey][$root][$raw] = (str_replace($rawValue,$array["$rawValue"],$product_map_array[$key][$subKey][$root][$raw]));
                                                        }
                                                        else if((array_search($rawValue, $product_map_array[$key][$subKey][$root]) != false) && $rawValue != null && isset($array[$rawValue]))
                                                        {
                                                            $product_map_array[$key][$subKey][$root][$raw] = (str_replace($rawValue,$array["$rawValue"],$product_map_array[$key][$subKey][$root][$raw]));
                                                        }
                                                        else
                                                        {
                                                            if(!isset($array[$rawValue]) && array_key_exists($rawValue, $array))
                                                            {
                                                                $product_map_array[$key][$subKey][$root][$raw] = null;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                if((in_array($rootValue, $product_map_array[$key][$subKey]) != false) && $rootValue != null && isset($array[$rootValue]))
                                                {
                                                    $product_map_array[$key][$subKey][$root] = (str_replace($rootValue,$array["$rootValue"],$product_map_array[$key][$subKey][$root]));
                                                }
                                                else if((array_search($rootValue, $product_map_array[$key][$subKey]) != false) && $rootValue != null && isset($array[$rootValue]))
                                                {
                                                    $product_map_array[$key][$subKey][$root] = (str_replace($rootValue,$array["$rootValue"],$product_map_array[$key][$subKey][$root]));
                                                }
                                                else
                                                {
                                                    if(!isset($array[$rootValue]) && array_key_exists($rootValue, $array))
                                                    {
                                                        $product_map_array[$key][$subKey][$root] = null;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if((in_array($subValue, $product_map_array[$key]) != false) && $subValue != null && isset($array[$subValue]))
                                        {
                                            $product_map_array[$key][$subKey] = (str_replace($subValue,$array["$subValue"],$product_map_array[$key][$subKey]));
                                        }
                                        else if((array_search($subValue, $product_map_array[$key]) != false) && $subValue != null && isset($array[$subValue]))
                                        {
                                            $product_map_array[$key][$subKey] = (str_replace($subValue,$array["$subValue"],$product_map_array[$key][$subKey]));
                                        }
                                        else
                                        {
                                            if(!isset($array[$subValue]) && array_key_exists($subValue, $array))
                                            {
                                                $product_map_array[$key][$subKey] = null;
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if((in_array($value, $product_map_array) != false) && $value != null && isset($array[$value]))
                                {
                                    $product_map_array[$key] = (str_replace($value,$array["$value"],$product_map_array[$key]));
                                }
                                else if((array_search($value, $product_map_array) != false) && $value != null && isset($array[$value]))
                                {
                                    $product_map_array[$key] = (str_replace($value,$array["$value"],$product_map_array[$key]));
                                }
                                else
                                {
                                    if(!isset($array[$value]) && array_key_exists($value, $array))
                                    {
                                        $product_map_array[$key] = null;
                                    }
                                }
                            }
                        }
                        //returns it in StdClass Format
                        $Product = new \stdClass();
                        $Product = json_decode(json_encode($product_map_array));
                        $Product->enable_html_description = true;

                        //gets the credentials
                        $storeName = $_wooSettings->Woocommerce_Store->store_name;
                        $ck = $_wooSettings->Woocommerce_Store->consumer_key;
                        $cs = $_wooSettings->Woocommerce_Store->consumer_secret;

                        //add the category
                        //check if the category is on Woocommerce
                        $isCategory = $this->woo_checkCategory($product, $_wooSettings);
                        if($isCategory != null)
                        {
                            $category_first = new \stdClass();
                            $category_first->id = $isCategory;
                            $Product->categories = $category_first;
                        }
                        else
                        {
                            //creates the attribute on Woocommerce
                            $id = $this->woo_createCategory($product->Category, $_wooSettings);
                            $category = array();
                            $category_ = new \stdClass();
                            $category_ = $id;

                            array_push($category, $category_);
                            //assigns the category to the product
                            $Product->categories = $category;
                        }

                        if($product->Type == 'Simple')
                        {
                            //Splits the products into variants and general
                            $variation_data = new \stdClass();
                            $variation_data->product = $Product->variations;
                            unset($Product->variations);
                            $general_data = new \stdClass();
                            $general_data->product = $Product;

                            //sets the product type to Simple
                            $Product->Type = 'Simple';

                            if($wooExist == true)
                            {
                                //if the product exists on woocommerce and is Simple
                                //update general information about product
                                //getProductId from database table
                                //OR gets the ID from Woocommerce
                                
                                $id = $this->getID($product->SKU, $connection);
                                if($id == null)
                                {
                                    //gets the ID from Woocommerce, saves it in Table
                                    $this->getSKUID($product, $_wooSettings, $connection);
                                    $id = $this->getID($product->SKU, $connection);
                                }
                                $url = 'https://' . $storeName. '/wc-api/v3/products/' . $id;
                                $result = $this->get_web_page($url, json_encode($general_data), $ck, $cs, 'put');

                                //check for any errors and log them
                                if(json_decode($result)->httpcode != 200)
                                {
                                    $connection->addLogs('Push Product - Woocommerce', 'Error occured: ' . json_decode($result)->httpcode, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true);
                                }
                                

                                //update variant information about product
                                //No Options (attributes)
                                $url = 'https://' . $storeName. '/wc-api/v3/products/' . $id;
                                $result = $this->get_web_page($url, json_encode($variation_data), $ck, $cs, 'put');
                                if(json_decode($result)->httpcode != 200)
                                {
                                    $connection->addLogs('Push Product - Woocommerce', 'Error occured: ' . json_decode($result)->httpcode, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true);
                                }
                                header('Content-Type: application/json');
                                echo($result);
                                exit();
                                
                            }
                            else
                            {

                            }
                        }
                        else
                        {

                        }

                        print_r($Product);
                        exit();

                        //add the attribute(options)


                        return $Product;
                    }
                }
                else
                {
                    //creates the product using internal map
                    $Product = new \stdClass();
                    $Product->title = $product->Title;
                    $Product->status = $_wooSettings->Woocommerce_Settings->woo_product_status;
                    $Product->description = $product->Description; //decodes it 
                    $Product->short_description = "";
                    if($product->Type == 'Simple')
                    {
                        $product->type = 'Simple';
                        $Product->managing_stock = false;
                    }
                    //Adds product options - attributes (single, variant)
                    //Options
                    if($product->Type != 'Simple')
                    {
                        //add the management inventory on variant level if variant
                        $Product->attributes = $this->woo_addOptionAttributes($product);
                    }
                    else
                    {
                        $Product->attributes = $this->woo_addAttributes($product);
                    }

                    //Adds product to category
                    $Product->categories = $this->woo_AddCategory($product);
                    $Product->variants = new \stdClass();
                    if($product->Type != 'Simple')
                    {
                        $Product->variants->managing_stock = false;
                    }
                    $Product->variants->sku = $product->SKU;
                    $Product->variants->stock_quantity = $product->CapeTown_Warehouse;
                    $Product->variants->regular_price = $product->ComparePrice;
                    $Product->variants->sale_price = $product->SellingPrice;
                    $Product->variants->weight = $product->Weight;
                    return $Product;
                }
            }
        }
        return null;
    }

    //Adds product options - attributes single
    function woo_addAttributes($product)
    {
        $attributes = array();
        $attr = new \stdClass();
        $attr->name = "Brand";
        $attr->slug = "brand";
        $attr->position = 1;
        $attr->visible = true;
        $attr->variation = false;
        $attr->options = ["$product->Brand"];

        $attr2 = new \stdClass();
        $attr2->name = "Product Type";
        $attr2->slug = "product-type";
        $attr2->position = 2;
        $attr2->visible = true;
        $attr2->variation = false;
        $attr2->options = ["$product->Meta_1"];

        $attr3 = new \stdClass();
        $attr3->name = "Version Released";
        $attr3->slug = "product-version";
        $attr3->position = 3;
        $attr3->visible = true;
        $attr3->variation = false;
        $attr3->options = ["$product->Meta_3"];

        array_push($attributes, $attr);
        array_push($attributes, $attr2);
        array_push($attributes, $attr3);
        return $attributes;
    }

    //adds the options to variable products
    function woo_addOptionAttributes($product)
    {
        $options = array();
        if($product->Option_1_Name != null && $product->Option_1_Value != null)
        {
            $option1 = new \stdClass();
            $option1->name = $product->Option_1_Name;
            $option1->option = $product->Option_1_Value;
            array_push($options, $option1);
        }
        if($product->Option_2_Name != null && $product->Option_2_Value != null)
        {
            $option2 = new \stdClass();
            $option2->name = $product->Option_2_Name;
            $option1->option = $product->Option_2_Value;
            array_push($options, $option2);

        }
        return $options;
    }

    //adds the category to the products (internal_map)
    function woo_addCategory($product)
    {
        $category = array();
        array_push($category,$product->Category);
        return $category;
    }

    //checks if the category exists on Woocommerce
    function woo_checkCategory($product, $_wooSettings)
    {
        $category = $product->Category;

        $storeName = $_wooSettings->Woocommerce_Store->store_name;
        $url = 'https://' . $storeName. '/wc-api/v3/products/categories';
        $ck = $_wooSettings->Woocommerce_Store->consumer_key;
        $cs = $_wooSettings->Woocommerce_Store->consumer_secret;

        $result = $this->get_web_page($url, null, $ck, $cs);
        $woo_categories = (json_decode($result))->product_categories;
        for($i = 0; $i < sizeof($woo_categories); ++$i)
        {
            if($woo_categories[$i]->name == $category)
            {
                return $woo_categories[$i]->id;
            }
        }
        return null;
    }

    //otherwise it creates a new category to add the product under
    function woo_createCategory($category, $_wooSettings)
    {
        $variable = new \stdClass();
        $variable->product_category = new \stdClass();
        $variable->product_category->name = $category;
        $variable = json_encode($variable);

        $storeName = $_wooSettings->Woocommerce_Store->store_name;
        $url = 'https://' . $storeName. '/wc-api/v3/products/categories';
        $ck = $_wooSettings->Woocommerce_Store->consumer_key;
        $cs = $_wooSettings->Woocommerce_Store->consumer_secret;

        return(json_decode($this->get_web_page($url, $variable, $ck, $cs, 'post'))->product_category->id);
    }

    //gets the products ID from Woocommerce and saves it in Table
    function getSKUID($product, $_wooSettings, $connection)
    {
        $sku = $product->SKU;

        $storeName = $_wooSettings->Woocommerce_Store->store_name;
        $url = 'https://' . $storeName. '/wc-api/v3/products?filter[sku]=' . $sku;
        $ck = $_wooSettings->Woocommerce_Store->consumer_key;
        $cs = $_wooSettings->Woocommerce_Store->consumer_secret;

        $id = (json_decode($this->get_web_page($url, null, $ck, $cs, ))->products[0]->id);
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        
        $query = "UPDATE Woocommerce SET 
        ID = '" . $id . "' 
        WHERE SKU = '" . $sku . "';";

        $output = $connection->converterObject($rawConnection, $query);
        print_r($output);
        exit();
    }

    //gets the products ID that has been saved in the database
    function getID($sku, $connection)
    {
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        
        $query = "SELECT ID FROM Woocommerce WHERE SKU = '" . $sku . "';";

        $output = $connection->converterObject($rawConnection, $query);
        return ($output)->result[0]->ID;
    }

}
?>