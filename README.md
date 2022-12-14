# Integrator Web App

## Main features

* Contains basic login and registration functionality
* Add and Customise product and customer data.
    * Data can be added and modified using API
    * Bulk import and export of data
* Can be run locally on using the application [XAMPP](https://www.apachefriends.org/)
* Product data can be integrated with major Ecommerce website [Woocomerce](https://woocommerce.com/blackcyber/) and Integration company [Stock2Shop](https.stock2shop.com/)
* Uses JSON format in API calls
* Contains an internal application to request Woocommerce and Stock2Shop data.

## Installation

Via Github:
* Download [zip](https://github.com/Keenan-Faure/Integration-web-app/archive/refs/heads/main.zip) file on repository page

Via Git CLI:

```
gh repo clone Keenan-Faure/Integration-web-app
```

* Download XAMPP using the URL in the description above
    * Extract file contents into htdocs folder
    * MySQL is required to be installed on the system, or simply run the MySql service in XAMPP
        * User needs to configure MySql to contain a secure admin user (not root)
        * User needs to create an appropriate database

## Documentation

### Configure ```MySQL, Stock2Shop and Woocommerce``` configuration files

The config files needs to be configured before:
- starting the application
- pushing product data to stock2shop
- pushing product data to woocommerce

Location of files:
```
intgration_web_app > config
```

Credentials can be entered in the respective php file.
* Open config file using Notepad++ or any editor of your choice and enter your credentials, Eg.

```php
<?php

    //MySQL credentials
    'dbUser' => 'username',
    'dbPass' => 'password',
    'dbName' => 'database'
);
?>;
```

Once these credentials have been entered, save the file and exit the editor.
You may now run the web application on localhost using XAMPP.

__Note__ If (Eg.) the Woocommerce file has not been correctly configured, no product data can be sent to your Woocommerce store.

## Woocommerce Connector

The pushing of data to Woocommerce is done using the [Woocommerce API](https://woocommerce.github.io/woocommerce-rest-api-docs/)

* Consists of an internal map and external map (defined in config) to push data
    * Internal map is for non-tech users
    * External map is for developers
* Has additional configuration settings defined in config.php
* Uses a custom created cURL method for API requests.
* Consists of a small application to request data from the respective store
* Creates new categories on Woocommerce
* Allows posting of HTML tags in product description
* JSON based requests and responses
* Request speed depends on Woocommerce server response times

### Integrator Application

* Ability to add multiple users to the console which has admin access
    * Users with admin access has full control over the application.
* Adding products
    * Via API
    * Via bulk import
    * Via forms inside app
* Adding customers
    * Via API
    * bulk import _not supported currently_
    * Via forms inside app
* Edit product and customer data
    * products support bulk export
    * bulk export not supported for customers
* Contains an Audit trail in lower right corner which shows which user edited product or customer data last format:
```
Last Edit made by {{User_Token}} on {{Data-Time}}
```

### Pushing Data to Woocommerce

* Pushing of product data to Woocommerce is done using a custom cURL `POST` and `GET` methods

## Receiving order from Woocommerce

Three conditions need to be met to receive order data:

* Does it come from the store defined in ```config > woo_settings.php```
* Does the ```id``` and ```token``` in the url exist on a user in the database
* Does the payload container the header ```X-Wc-Webhook-Resource ``` which should be equivalent to the value ```order```

### Setting-up webhook URL for Woocommerce 

__Note__ This guide is not an absolute bullet proof way of adding a webhook on Woocommerce.

* Login to your Woocommerce back-end > Woocommerce > Settings > Advanced > Webhooks > Add Webhook
* Status = active
* Topic = order.updated
* Delivery URL = ```{{forwarding url}}/orders/order.php?q={{user_id}}&token={{token}}```
   * Token and User_ID can be found in the table on the Dashboard > Click mysql icon (top-left) > Manage Users
* API Version = Legacy API v3 depreciated

### Receiving orders from Woocommerce

Localhost:

* If the application is running on localhost and not on a web server, and application like [Ngrok](https://ngrok.com/download) is needed to create a tunnel in order to expose the application to the outside world and, hence, receive request from outside as well - like webhook data
   * [Download](https://ngrok.com/download) ngrok on the OS of your choice
   * Start a tunnel by entering - localhost uses port ```80``` for XAMPP users
   ```
   ngrok http {{port}}
   ```
   * Notice the forwarding url for your localhost port it will be used when setting up the webhook:
   ![image](https://user-images.githubusercontent.com/97687673/207537012-70e7bb30-af57-4261-96ae-2dd6cee9876b.png)

Web Server:

* If the application is running on a web server, it has no need for Ngrok.
* Simple copy the website url and replace the {{forwarding url}} for your website url 
   * __eg.__ https://192.217.68.215 would replace the forwarding url and navigate to the order.php file in the url
   
   




