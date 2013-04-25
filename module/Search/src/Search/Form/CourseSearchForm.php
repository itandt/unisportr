<?php
namespace Search\Form;

use Zend\Form\Form;
use Cache\Model\CityStorage;
use Cache;
use ITT\Util\Utility;

class CourseSearchForm extends Form {

	private $cities;
	
	public function __construct(array $cities) {
		parent::__construct('courseSearch');
		$this->setCities($cities);
		$this->setAttribute('method', 'get');
		$this->setAttribute('id', 'searchForm');
		$this->add(array(
			'name' => 'keyword',
			'attributes' => array(
				'type'  => 'text',
				'id'  => 'searchFormKeyword',
			),
			'options' => array(
				'label' => Utility::poedit('Keyword'),
				'label_attributes' => array(
					// 'style' => 'display: none;' // works
				)
			),
		));
		$this->add(array(
			'name' => 'trainer',
			'attributes' => array(
				'type'  => 'text',
				'id'  => 'searchFormTrainer',
			),
			'options' => array(
				'label' => Utility::poedit('trainer'),
			),
		));
		$this->add(array(
			'name' => 'city',
			'type'  => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => Utility::poedit('city'),
				'value_options' => $this->cities,
			),
			'attributes' => array(
				'id'  => 'searchFormCity',
			),
		));
		// Deactivated so far, since a lot of courses have no levels (NULL).
		/*
		$this->add(array(
			'name' => 'level',
			'type'  => 'Zend\Form\Element\Radio',
			'attributes' => array(
				'value' => 2,
				'id'  => 'searchFormLevel',
			),
			'options' => array(
				'label' => Utility::poedit('level'),
				'value_options' => array(
					'1' => Utility::poedit('Beginner'),
					'2' => Utility::poedit('Intermediate'),
					'3' => Utility::poedit('Advanced'),
				),
			),
		));
		*/
		$this->add(array(
			'name' => 'weekday',
			'type'  => 'Zend\Form\Element\MultiCheckbox',
			'attributes' => array(
				'id'  => 'searchFormWeekday',
				'value' => array(1, 2, 3, 4, 5, 6, 7)
			),
			'options' => array(
				'label' => Utility::poedit('weekday'),
				'label_attributes' => array(
					'for' => false
				),
				'value_options' => array(
					'1' => Utility::poedit('Mo'),
					'2' => Utility::poedit('Tu'),
					'3' => Utility::poedit('We'),
					'4' => Utility::poedit('Th'),
					'5' => Utility::poedit('Fr'),
					'6' => Utility::poedit('Sa'),
					'7' => Utility::poedit('Su'),
				),
			),
		));
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => Utility::poedit('Find courses!'),
				'id' => 'searchFormSubmit',
			),
		));
	}
	
	public function setCities(array $cities) {
		$this->cities = array();
		foreach ($cities as $city) {
			$this->cities[$city->id] = $city->name;
		}
	}
	
}