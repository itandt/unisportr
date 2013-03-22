<?php
namespace Catalog\Model;

use Zend\Stdlib\ArraySerializableInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class City {
	
	public $id;
	public $name;
	
	public function exchangeArray(array $data) {
		$this->id   = (isset($data['id'])) ? $data['id'] : null;
		$this->name = (isset($data['name'])) ? $data['name'] : null;
	}
	
}