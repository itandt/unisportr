<?php
namespace Catalog\Model;

use Zend\Stdlib\ArraySerializableInterface;

class Sport implements ArraySerializableInterface {

	public $id;
	public $title;
	public $category;
	public $courseID;
	public $countCourses;
	
	public function exchangeArray(array $data) {
		$this->id			= (isset($data['id'])) ? $data['id'] : null;
		$this->title		= (isset($data['title'])) ? $data['title'] : null;
		$this->category		= (isset($data['category'])) ? $data['category'] : null;
		$this->courseID		= (isset($data['courseID'])) ? $data['courseID'] : null;
		$this->countCourses	= (isset($data['countCourses'])) ? $data['countCourses'] : null;
	}
	
	public function getArrayCopy() {
		return get_object_vars($this);
	}
	
}