<?php
namespace Course\Model;

use Zend\Stdlib\ArraySerializableInterface;

class Course implements ArraySerializableInterface {

	public $id;
	public $title;
	public $description; // +
	public $startDate;
	public $endDate;
	public $startTime;
	public $endTime;
	public $priceStudent; // +
	public $priceEmployee; // +
	public $priceNormal; // +
	public $status; // +
	public $weekday;
	public $usrLevelMin;
	public $usrLevelMax;
	public $uniLevelMin;
	public $uniLevelMax;
	public $trainers; // +
	public $city; // +
	public $bookingLink; // +
	public $courseID01; // +
	public $courseID02; // +
	public $location; // +
	public $url; // +
	public $providerId;
	public $providerName;
	public $providerType;
	public $providerURL;
	public $providerStatus;
	public $sport; // +
	public $sports; // +
	
	public function exchangeArray(array $data) {		
		$this->id				= (isset($data['id'])) ? $data['id'] : null;
		$this->title			= (isset($data['title'])) ? $data['title'] : null;
		$this->description		= (isset($data['description'])) ? $data['description'] : null;
		$this->startDate		= (isset($data['startDate'])) ? $data['startDate'] : null;
		$this->endDate			= (isset($data['endDate'])) ? $data['endDate'] : null;
		$this->startTime		= (isset($data['startTime'])) ? $data['startTime'] : null;
		$this->endTime			= (isset($data['endTime'])) ? $data['endTime'] : null;
		$this->priceStudent		= (isset($data['priceStudent'])) ? $data['priceStudent'] : null;
		$this->priceEmployee	= (isset($data['priceEmployee'])) ? $data['priceEmployee'] : null;
		$this->priceNormal		= (isset($data['priceNormal'])) ? $data['priceNormal'] : null;
		$this->status			= (isset($data['status'])) ? $data['status'] : null;
		$this->weekday			= (isset($data['weekday'])) ? $data['weekday'] : null;
		$this->usrLevelMin		= (isset($data['usrLevelMin'])) ? $data['usrLevelMin'] : null;
		$this->usrLevelMax		= (isset($data['usrLevelMax'])) ? $data['usrLevelMax'] : null;
		$this->uniLevelMin		= (isset($data['uniLevelMin'])) ? $data['uniLevelMin'] : null;
		$this->uniLevelMax		= (isset($data['uniLevelMax'])) ? $data['uniLevelMax'] : null;
		$this->trainers			= (isset($data['trainers'])) ? $data['trainers'] : null;
		$this->city				= (isset($data['city'])) ? $data['city'] : null;
		$this->bookingLink		= (isset($data['bookingLink'])) ? $data['bookingLink'] : null;
		$this->courseID01		= (isset($data['courseID01'])) ? $data['courseID01'] : null;
		$this->courseID02		= (isset($data['courseID02'])) ? $data['courseID02'] : null;
		$this->location			= (isset($data['location'])) ? $data['location'] : null;
		$this->url				= (isset($data['url'])) ? $data['url'] : null;
		$this->providerID		= (isset($data['providerId'])) ? $data['providerId'] : null;
		$this->providerName		= (isset($data['providerName'])) ? $data['providerName'] : null;
		$this->providerType		= (isset($data['providerType'])) ? $data['providerType'] : null;
		$this->providerURL		= (isset($data['providerURL'])) ? $data['providerURL'] : null;
		$this->providerStatus	= (isset($data['providerStatus'])) ? $data['providerStatus'] : null;
		$this->sport			= (isset($data['sport'])) ? $data['sport'] : null;
		$this->sports			= (isset($data['sports'])) ? $data['sports'] : null;
	}
	
	public function getArrayCopy() {
		return get_object_vars($this);
	}
	
}