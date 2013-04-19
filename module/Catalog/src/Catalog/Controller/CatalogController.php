<?php
namespace Catalog\Controller;

use Catalog\Model\City;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalog\Model\SportTable;
use Catalog\Model\CityTable;
use Catalog\Model\CourseTable;

/**
 * CatalogController
 * 
 * @author automatix
 */
class CatalogController extends AbstractActionController {

	protected $cityTable;
	protected $sportTable;
	protected $courseTable;
	
	public function listCitiesAction() {
		return new ViewModel(array(
			'cities' => $this->getServiceLocator()->get('Cache\Model\CityStorage')->getCities(),
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
		$cityName = $this->params()->fromRoute('city', null);
		$sportTitle = $this->params()->fromRoute('sport', null);
		$page = $this->params()->fromRoute('page');
		$paginator = $this->getCourseTable()->findAllByCityNameAndSportTitle($cityName, $sportTitle, $page);
		return new ViewModel(array(
			'city' => $cityName,
			'sport' => $sportTitle,
			'paginator' => $paginator
		));
	}
	
	/**
	 * Gets a SportTable object.
	 * @return SportTable
	 */
	function getSportTable() {
		if (!$this->sportTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->sportTable = $serviceLocator->get('Catalog\Model\SportTable');
		}
		return $this->sportTable;
	}
	
	/**
	 * Gets a CourseTable object.
	 * @return CourseTable
	 */
	function getCourseTable() {
		if (!$this->courseTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->courseTable = $serviceLocator->get('Catalog\Model\CourseTable');
		}
		return $this->courseTable;
	}
}