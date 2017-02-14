<?php

namespace Swikly;

/**
 **
 ** The SwiklyAPI class let you call our API in an easy way.
 ** All the API routes are implemented and you can use them
 ** with only one function call.
 **
 */
class SwiklyAPI {

	private $apiKey;
	private $apiSecret;

	private $optFields;

	public function __construct($apiKey, $apiSecret, $env) {
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
		$env = strtolower($env);
		$this->url = "https://api.sandbox.swikly.com";
		if (strpos($env, 'prod') !== false) {
			$this->url = "https://api.swikly.com";
		}
		$this->optFields = ['email', 'business_pays', 'last_name', 'first_name', 'phone_number', 'swik_type'];
	}

	public function setApiKey($key) {
		$this->apiKey = $key;
		return $this;
	}

	public function setApiSecret($secret) {
		$this->apiSecret = $secret;
		return $this;
	}

	// Handle curl error
	private function getCurlError($ch, $response) {
		if(curl_errno($ch)) {
		    $response['status']  = 'ko';
		    $response['message'] = 'Connection error: ' . curl_error($ch);
		}
		return $response;
	}

	public function newSwik(\Swikly\Swik $swik) {
		// set required parameters
		$data = array (
			'swik_amount' => $swik->getSwikAmount(),
			'swik_description' => $swik->getSwikDescription(),
			'swik_end_day' => $swik->getSwikEndDay(),
			'swik_end_month' => $swik->getSwikEndMonth(),
			'swik_end_year' => $swik->getSwikEndYear(),
			'id' => $swik->getSwikId(),
			'client_email' => $swik->getClientEmail(),
			'swik_lang' => $swik->getClientLanguage(),
			'callback_url' => $swik->getCallbackUrl(),
		);

		// set optionnal parameters
		$optParams = $swik->getOptionnalParams();
		$len = count($this->optFields);
		for ($i = 0; $i < $len; $i++) {
			if (isset($optParams[$this->optFields[$i]])) {
				$data[$this->optFields[$i]] = $optParams[$this->optFields[$i]];
			}
		}

		$headerData = array(
			'Content-type: application/x-www-form-urlencoded',
            "API_KEY: " . $this->apiKey,
			"API_SECRET: " . $this->apiSecret
		);

		$data = http_build_query($data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url . '/v1_0/newSwik');
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$json = json_decode($result, true);

		// Check for curl error and set the result accordingly
		$json = $this->getCurlError($ch, $json);

		return $json;
	}

	public function newDirectSwik(\Swikly\Swik $swik) {
		// set required parameters
		$data = array (
			'swik_amount' => $swik->getSwikAmount(),
			'swik_description' => $swik->getSwikDescription(),
			'swik_end_day' => $swik->getSwikEndDay(),
			'swik_end_month' => $swik->getSwikEndMonth(),
			'swik_end_year' => $swik->getSwikEndYear(),
			'id' => $swik->getSwikId(),
			'client_email' => $swik->getClientEmail(),
			'swik_lang' => $swik->getClientLanguage(),
			'callback_url' => $swik->getCallbackUrl(),
		);

		// set optionnal parameters
		$optParams = $swik->getOptionnalParams();
		$len = count($this->optFields);
		for ($i = 0; $i < $len; $i++) {
			if (isset($optParams[$this->optFields[$i]])) {
				$data[$this->optFields[$i]] = $optParams[$this->optFields[$i]];
			}
		}

		$headerData = array(
            "API_KEY: " . $this->apiKey,
			"API_SECRET: " . $this->apiSecret
		);

		$data = http_build_query($data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url . '/v1_0/integratedSwik');
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$resp = curl_exec($ch);

		// Check for curl error and set the result accordingly
		$result = $this->getCurlError($ch, $resp);

		curl_close($ch);

		// Handle the data when request succeed
		if ((isset($result['status']) && $result['status'] != 'ko') || !isset($result['status'])) {

			// Split the header and body data
			list($headers, $jsonResponse) = explode("\r\n\r\n", $resp, 2);

			// Parse the header for redirection
			preg_match_all('/^Location:(.*)$/mi', $headers, $matches);

			$result = !empty($matches[1]) ? array('redirect' => trim($matches[1][0])) : array('redirect' => '');

			// Create a json object01
			$response = json_decode($jsonResponse, true);
		}

		return isset($response) && is_array($response) ? array_merge($result, $response) : $result;
	}

	public function deleteSwik(\Swikly\Swik $swik) {
		// set required parameters
		$data = array (
			'id' => $swik->getSwikId()
		);

		// set optionnal parameter
		$email = $swik->getSendEmail();
		if ($email) {
			$data['email'] = $email;
		}

		$headerData = array(
			'Content-type: application/x-www-form-urlencoded',
            "API_KEY: " . $this->apiKey,
			"API_SECRET: " . $this->apiSecret
		);

		$data = http_build_query($data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url . '/v1_0/cancelSwik');
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$json = json_decode($result, true);

		// Check for curl error and set the result accordingly
		$json = $this->getCurlError($ch, $json);

		return $json;
	}

	public function getListSwik() {
		$headerData = array(
			'Content-type: application/x-www-form-urlencoded',
            "API_KEY: " . $this->apiKey,
			"API_SECRET: " . $this->apiSecret
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url . '/v1_0/listSwik');
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$json = json_decode($result, true);

		// Check for curl error and set the result accordingly
		$json = $this->getCurlError($ch, $json);

		return $json;
	}

	public function getSwik($swik) {
		$headerData = array(
			'Content-type: application/x-www-form-urlencoded',
			"API_KEY: " . $this->apiKey,
			"API_SECRET: " . $this->apiSecret
		);

		$swikId = $swik->getSwikId();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url . '/v1_0/getSwik?id=' . $swikId);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$json = json_decode($result, true);

		// Check for curl error and set the result accordingly
		$json = $this->getCurlError($ch, $json);

		return $json;
	}

}
