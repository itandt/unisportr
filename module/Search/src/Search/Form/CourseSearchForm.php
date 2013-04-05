<?php
namespace Search\Form;

use Zend\Form\Form;
use Cache\Model\CityStorage;
use Cache;

class CourseSearchForm extends Form {

	private $cities;
	
	public function __construct(array $cities) {
		parent::__construct('courseSearch');
		$this->setCities($cities);
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'keyword',
			'attributes' => array(
				'type'  => 'text',
			),
		));
		$this->add(array(
			'name' => 'trainer',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Trainer',
			),
		));
		$this->add(array(
			'name' => 'city',
			'type'  => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Stadt',
				'value_options' => $this->cities
			),
		));
		$this->add(array(
			'name' => 'level',
			'type'  => 'Zend\Form\Element\Radio',
			'attributes' => array(
			),
			'options' => array(
				'label' => 'Level',
				'value_options' => array(
					'1' => 'Beginner',
					'2' => 'Intermediate',
					'3' => 'Advanced',
				),
			),
		));
		$this->add(array(
			'name' => 'weekday',
			'type'  => 'Zend\Form\Element\MultiCheckbox',
			'attributes' => array(
			),
			'options' => array(
				'label' => 'Weekday',
				'value_options' => array(
					'1' => 'Mo',
					'2' => 'Tu',
					'3' => 'We',
					'4' => 'Th',
					'5' => 'Fr',
					'6' => 'Sa',
					'7' => 'Su',
				),
			),
		));
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Find courses!',
				'id' => 'searchFormSubmit',
			),
		));
	}
	
	public function setCities(array $cities) {
		$this->cities = $cities;
	}
	
}