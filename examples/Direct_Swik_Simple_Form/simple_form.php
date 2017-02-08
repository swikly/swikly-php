<?php

require_once('../../init.php');

use Swikly\SwiklyAPI;
use Swikly\Swik;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
	$swkAPI = new SwiklyAPI('Your_Api_Key', 'YOUR_API_SECRET', 'development');

	function makeNewDirectSwik($id, $userData) {

		global $swkAPI;
		// Create a swik object
		$swik = new Swik();

		// Set all the swik informations with the $_POST data
		$swik->setClientFirstName($userData['firstName'])
		    ->setClientLastName($userData['lastName'])
		    ->setClientEmail($userData['emailUser'])
		    ->setClientPhoneNumber($userData['phoneNumber'])
		    ->setClientLanguage("FR")
		    ->setSwikAmount("35")
		    ->setSwikDescription("A short description of the swik")
		    ->setSwikEndDay("12")
		    ->setSwikEndMonth("04")
		    ->setSwikEndYear("2017")
		    ->setSwikId($id)
		    ->setSendEmail("false")
		    ->setCallbackUrl('http://mywebsite.com/confirmation');

	    // Create the new Swik and get the redirect URL to validate it
	    $result = $swkAPI->newDirectSwik($swik);

	    // Log the error if one occured and return the result
	    if (isset($result['status']) && $result['status'] == 'ko') {
	        error_log("Failed to create a swik " . $result['message']);
	    }
	    return $result;
	}

	// Be careful you can only use an Id once
	echo json_encode(makeNewDirectSwik('MY_ID', $_POST));
}