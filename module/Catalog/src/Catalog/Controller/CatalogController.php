<?php
namespace Catalog\Controller;

use Catalog\Model\City;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalog\Model\SportTable;
use Catalog\Model\CityTable;

/**
 * CatalogController
 * 
 * @author automatix
 */
class CatalogController extends AbstractActionController {

	protected $cityTable;
	protected $sportTable;
	
	public function listCitiesAction() {
		return new ViewModel(array(
			'cities' => $this->getCityTable()->fetchAll()
		));
	}
	
	public function listSportsAction() {
		$cityName = $this->params()->fromRoute('city', null);
		return new ViewModel(array(
			'city' => $cityName,
			'sports' => $this->getSportTable()->findAllByCityName($cityName)
		));
	}
	
	public function listCoursesAction() {
		return new ViewModel(array(
			'sport' => $this->params()->fromRoute('sport', null),
			'city' => $this->params()->fromRoute('city', null)
		));
	}

	/**
	 * Gets a CityTable object.
	 * @return CityTable
	 */
	function getCityTable() {
		if (!$this->cityTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->cityTable = $serviceLocator->get('CityTable');
		}
		return $this->cityTable;
	}
	
	/**
	 * Gets a SportTable object.
	 * @return SportTable
	 */
	function getSportTable() {
		if (!$this->sportTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->sportTable = $serviceLocator->get('SportTable');
		}
		return $this->sportTable;
	}
}