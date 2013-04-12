<?php
namespace Catalog\Model;

use Zend\Stdlib\ArraySerializableInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class University implements ArraySerializableInterface {
	
	public $id;
	public $displayedName;
	public $formalName;
	public $type;
	public $dateTimeCreated;
	public $dateTimeLastUpdate;
	public $status;
	public $numUpdates;
	public $numCourses;
	public $url;
	public $urlSport;
	public $cityID;
	public $sport;
	public $numStudents;
	public $scrape;
	public $cityName;
	
	public function exchangeArray(array $data) {
		$this->id   				= (isset($data['id'])) ? $data['id'] : null;
		$this->displayedName 		= (isset($data['displayedName'])) ? $data['displayedName'] : null;
		$this->formalName 			= (isset($data['formalName'])) ? $data['formalName'] : null;
		$this->type 				= (isset($data['type'])) ? $data['type'] : null;
		$this->dateTimeCreated 		= (isset($data['dateTimeCreated'])) ? $data['dateTimeCreated'] : null;
		$this->dateTimeLastUpdate 	= (isset($data['dateTimeLastUpdate'])) ? $data['dateTimeLastUpdate'] : null;
		$this->status 				= (isset($data['status'])) ? $data['status'] : null;
		$this->numUpdates 			= (isset($data['numUpdates'])) ? $data['numUpdates'] : null;
		$this->numCourses 			= (isset($data['numCourses'])) ? $data['numCourses'] : null;
		$this->url 					= (isset($data['url'])) ? $data['url'] : null;
		$this->urlSport 			= (isset($data['urlSport'])) ? $data['urlSport'] : null;
		$this->cityID 				= (isset($data['cityID'])) ? $data['cityID'] : null;
		$this->sport 				= (isset($data['sport'])) ? $data['sport'] : null;
		$this->numStudents 			= (isset($data['numStudents'])) ? $data['numStudents'] : null;
		$this->scrape 				= (isset($data['scrape'])) ? $data['scrape'] : null;
		$this->cityName 			= (isset($data['cityName'])) ? $data['cityName'] : null;
	}
	
	public function getArrayCopy() {
		return get_object_vars($this);
	}
	
	public function toArray() {
		return $this->getArrayCopy();
	}
	
}