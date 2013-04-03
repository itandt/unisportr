<?php
namespace Search\Form;

use Zend\Form\Form;

class CourseSearchForm extends Form {
	
	public function __construct() {
		parent::__construct('courseSearch');
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
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Stadt',
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
	
	
}