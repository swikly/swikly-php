# Swikly PHP SDK

You can sign up to get a [Swikly](https://www.swikly.com) account [here](https://www.swikly.com/user_signup_self.php).

## Requirements

PHP 5.6.0 and later.

## Composer

You can install the **Swikly SDK** via [Composer](https://getcomposer.org/):

```bash
composer require swikly/swikly-php
```

To use the SDK, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading)

```PHP
require_once('vendor/autoload.php');
```

## Manual installation

If you do not wish to use Composer, you can download the sources. Then, to use the SDK, include the `init.php` file.

```PHP
require_once('/path/to/swikly-php/init.php');
```

## Ressources

[Wiki](https://github.com/swikly/swikly-php/wiki): To understand all the SDK features and how to use them.

[Github repository](https://github.com/swikly/swikly-php): Examples are available in the examples directory.

[API documentation](https://api.sandbox.swikly.com/apidoc/): A documentation up to date about the API used by this SDK.

## Quick examples

### Create a Swikly API client
```PHP
<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';

use Swikly\Swik;
use Swikly\SwiklyAPI;

//Instantiate a Swikly API client
$swkAPI = new SwiklyAPI('Your_Api_Key', 'YOUR_API_SECRET', 'development');

```

### Create a new Swik

```PHP
<?php
// Create a swik object
$swik = new Swik();

// Set all the swik informations
$swik->setClientFirstName("Jean")
    ->setClientLastName("Dupont")
    ->setClientEmail("jean.dupont@gmail.com")
    ->setClientPhoneNumber("+33 6 20 20 20 20") // Send SMS to that number
    ->setClientLanguage("FR") // "EN" or "FR"
    ->setSwikAmount("50")
    ->setSwikDescription("1h de canyoning le 12/08/2017....")
    ->setSwikEndDay("12")
    ->setSwikEndMonth("08")
    ->setSwikEndYear("2017")
    ->setSwikId("YOUR_ID")
    ->setSendEmail("true")
    ->setSwikType("security deposit") // "reservation" or "security deposit"
    ->setCallbackUrl('https://mywebsite.com/resultSwik');

// Create and send your new swik to your client
$result = $swkAPI->newSwik($swik);

// Print result of the operation
if ($result['status'] == 'ok') {
	echo "New swik created\n";
    echo "Your client can accept the swik at that address: " . $result['acceptUrl'];
} else {
	echo "Failed create swik";
	echo "Error = " . $result['message'];
}
```

### Cancel a swik:

```PHP
<?php

// Create a swik object
$swik = new Swik();

// Set the Id you used to create it
$swik->setSwikId("YOUR_ID");

// Deleting the swik
$result = $swkAPI->deleteSwik($swik);

// Print result of the operation
if ($result['status'] == 'ok') {
    echo "Swik deleted correctly";
} else {
    echo "Failed delete swik";
    echo "Error = " . $result['message'];
}
```

### List all my Swiks

```PHP
<?php

// Get the list of your swiks
$result = $swkAPI->getListSwik();

// Print result of the operation
if ($result['status'] == 'ok') {
    echo "List of swik(s) = ";
    print_r($result['list']);
} else {
    echo "Failed getting the swik list";
    echo "Error = " . $result['message'];
}
```
