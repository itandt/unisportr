<?php
namespace Search\Model;

use Zend\Stdlib\ArraySerializableInterface;

class Course implements ArraySerializableInterface {

	public $id;
	public $title;
	public $description;
	public $startDate;
	public $endDate;
	public $startTime;
	public $endTime;
	public $providerName;
	public $providerType;
	public $city;
	public $weekday;
	public $usrLevelMin;
	public $usrLevelMax;
	public $uniLevelMin;
	public $uniLevelMax;
	public $relevance;
	
	public function exchangeArray(array $data) {
		$this->id				= (isset($data['id'])) ? $data['id'] : null;
		$this->title			= (isset($data['title'])) ? $data['title'] : null;
		$this->description		= (isset($data['description'])) ? $data['description'] : null;
		$this->startDate		= (isset($data['startDate'])) ? $data['startDate'] : null;
		$this->endDate			= (isset($data['endDate'])) ? $data['endDate'] : null;
		$this->startTime		= (isset($data['startTime'])) ? $data['startTime'] : null;
		$this->endTime			= (isset($data['endTime'])) ? $data['endTime'] : null;
		$this->providerName		= (isset($data['providerName'])) ? $data['providerName'] : null;
		$this->providerType		= (isset($data['providerType'])) ? $data['providerType'] : null;
		$this->city				= (isset($data['city'])) ? $data['city'] : null;
		$this->weekday			= (isset($data['weekday'])) ? $data['weekday'] : null;
		$this->usrLevelMin		= (isset($data['usrLevelMin'])) ? $data['usrLevelMin'] : null;
		$this->usrLevelMax		= (isset($data['usrLevelMax'])) ? $data['usrLevelMax'] : null;
		$this->uniLevelMin		= (isset($data['uniLevelMin'])) ? $data['uniLevelMin'] : null;
		$this->uniLevelMax		= (isset($data['uniLevelMax'])) ? $data['uniLevelMax'] : null;
		$this->relevance		= (isset($data['relevance'])) ? $data['relevance'] : null;
	}
	
	public function getArrayCopy() {
		return get_object_vars($this);
	}
	
}