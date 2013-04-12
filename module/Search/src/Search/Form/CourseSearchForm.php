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
		$this->setAttribute('id', 'searchForm');
		$this->add(array(
			'name' => 'keyword',
			'attributes' => array(
				'type'  => 'text',
				'id'  => 'searchFormKeyword',
			),
			'options' => array(
				'label' => 'Keyword',
				'label_attributes' => array(
					// 'style' => 'display: none;' // works
				)
			),
		));
		$this->add(array(
			'name' => 'trainer',
			'attributes' => array(
				'type'  => 'text',
				'id'  => 'formElementTrainer',
			),
			'options' => array(
				'label' => 'trainer',
			),
		));
		$this->add(array(
			'name' => 'city',
			'type'  => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'city',
				'value_options' => $this->cities,
				'id'  => 'searchFormCity',
			),
		));
		$this->add(array(
			'name' => 'level',
			'type'  => 'Zend\Form\Element\Radio',
			'attributes' => array(
				'id'  => '',
				'value' => 2
			),
			'options' => array(
				'label' => 'level',
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
				'id'  => '',
				'value' => array(1, 2, 3, 4, 5, 6, 7)
			),
			'options' => array(
				'label' => 'weekday',
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