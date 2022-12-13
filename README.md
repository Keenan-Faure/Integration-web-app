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
    * Users will admin access has full control over the application.
* Adding products
    * Via API
    * Via bulk import
    * Via in app form
* Adding customers
    * Via API
    * bulk import _not supported_
    * Via in app form
* Edit product and customer data
    * products support bulk export
    * bulk export not supported for customers
* Contains an Audit trail in lower right corner which shows which user edited product or customer data last format:
```
Last Edit made by {{User}} on {{Data-Time}}
```

### Pushing Data to Woocommerce

* Pushing of product data to Woocommerce is done using the custom cURL `POST` and `GET` methods




