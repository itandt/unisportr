<?php
namespace Search\Model;

use Zend\Stdlib\ArraySerializableInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CourseSearchInput implements ArraySerializableInterface {
	
	private $dataSet;
	protected $inputFilter;
	
	public function __construct() {
		$this->dataSet = array(
			'keyword'	=> null,
			'trainer'	=> null,
			'city'		=> null,
			'level'		=> null,
			'weekday'	=> null,
		);
	}
	
	/**
	 * Sets $this->dataSet to the values (of the accordant keys) of the input array.
	 * @throws \InvalidArgumentException If the input array contains not all keys of $this->dataSet.
	 * @see \Zend\Stdlib\ArraySerializableInterface::exchangeArray()
	 */
	public function exchangeArray(array $data) {
		if (count(array_diff_key($this->dataSet, $data)) == 0) {
			foreach ($this->dataSet as $k => $v) {
				$this->dataSet[$k] = $data[$k];
			}
		} else {
			throw new \InvalidArgumentException('The input array needs to contain all objects data set.', null, null);
		}
	}

	/**
	 * @see \Zend\Stdlib\ArraySerializableInterface::getArrayCopy()
	 */
	public function getArrayCopy() {
		return $this->dataSet;
	}
	
	public function getInputFilter() {
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'     => 'keyword',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 50,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'     => 'city',
				'required' => true,
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'     => 'trainer',
				'required' => false,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 50,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'     => 'level',
				'required' => true,
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'     => 'weekday',
				'required' => true,
			)));
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception('The method ' . __CLASS__ . '#' . __METHOD__ . ' is not used.');
	}

	
	
	
}