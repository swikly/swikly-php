<?php

namespace Swikly;

/**
**
** The Swik class let you create and manage Swiks.
** Simple class with setter and getter.
**
*/
class Swik {
	private $clientFirstName;
	private $clientLastName;
	private $clientPhoneNumber;
	private $clientEmail;
	private $clientLanguage;
	private $sendEmail;
	private $swikAmount;
	private $swikDescription;
	private $swikEndDay;
	private $swikEndMonth;
	private $swikEndYear;
	private $swikId;
	private $swikType;
	private $callbackUrl;
	private $businessPays;

	//All the setters
	public function setClientFirstName($firstName) {
		$this->clientFirstName = $firstName;
		return $this;
	}

	public function setClientLastName($lastName) {
		$this->clientLastName = $lastName;
		return $this;
	}

	public function setClientPhoneNumber($phoneNumber) {
		$this->clientPhoneNumber = $phoneNumber;
		return $this;
	}

	public function setClientEmail($email) {
		$this->clientEmail = $email;
		return $this;
	}

	public function setClientLanguage($lang) {
		$this->clientLanguage = $lang;
		return $this;
	}

	public function setSendEmail($sendEmail) {
		$this->sendEmail = $sendEmail;
		return $this;
	}

	public function setSwikAmount($amount) {
		$this->swikAmount = $amount;
		return $this;
	}

	public function setSwikDescription($desc) {
		$this->swikDescription = $desc;
		return $this;
	}

	public function setSwikEndDay($day) {
		$this->swikEndDay = $day;
		return ($this);
	}

	public function setSwikEndMonth($month) {
		$this->swikEndMonth = $month;
		return $this;
	}

	public function setSwikEndYear($year) {
		$this->swikEndYear = $year;
		return $this;
	}

	public function setSwikId($id) {
		$this->swikId = $id;
		return $this;
	}

	public function setCallbackUrl($url) {
		$this->callbackUrl = $url;
		return $this;
	}

	public function setSwikType($type) {
		$this->swikType = $type;
		return $this;
	}

	// All the getter

	public function getClientFirstName() {
		return $this->clientFirstName;
	}

	public function getClientLastName() {
		return $this->clientLastName;
	}

	public function getClientPhoneNumber() {
		return $this->clientPhoneNumber;
	}

	public function getClientEmail() {
		return $this->clientEmail;
	}

	public function getClientLanguage() {
		return $this->clientLanguage;
	}

	public function getSendEmail() {
		return $this->sendEmail;
	}

	public function getSwikAmount() {
		return $this->swikAmount;
	}

	public function getSwikDescription() {
		return $this->swikDescription;
	}

	public function getSwikEndDay() {
		return $this->swikEndDay;
	}

	public function getSwikEndMonth() {
		return $this->swikEndMonth;
	}

	public function getSwikEndYear() {
		return $this->swikEndYear;
	}

	public function getSwikId() {
		return $this->swikId;
	}

	public function getCallbackUrl() {
		return $this->callbackUrl;
	}

	public function getSwikType() {
		return $this->swikType;
	}

	public function getOptionnalParams() {
		return ['email' => $this->sendEmail,
				'business_pays' => $this->businessPays,
				'last_name' => $this->clientLastName,
				'first_name' => $this->clientFirstName,
				'phone_number' => $this->clientPhoneNumber,
				'swik_type' => $this->swikType
				];
	}
}
