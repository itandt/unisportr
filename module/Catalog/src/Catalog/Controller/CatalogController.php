<?php
namespace Catalog\Controller;

use Catalog\Model\City;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * CatalogController
 * 
 * @author automatix
 */
class CatalogController extends AbstractActionController {
	
	protected $cityTable;
	
	public function listCitiesAction() {
		return new ViewModel(array(
			'cities' => $this->getCityTable()->fetchAll()
		));
	}
	
	public function listSportsAction() {
		return new ViewModel(
			array('city' => $this->params()->fromRoute('city', null))
		);
	}
	
	public function listCoursesAction() {
		return new ViewModel(array(
			'sport' => $this->params()->fromRoute('sport', null),
			'city' => $this->params()->fromRoute('city', null)
		));
	}
	
	function getCityTable() {
		if (!$this->cityTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->cityTable = $serviceLocator->get('Catalog\Model\CityTable');
		}
		return $this->cityTable;
	}
}