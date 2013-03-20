<?php
namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * CatalogController
 * 
 * @author automatix
 */
class CatalogController extends AbstractActionController {
	
	public function listCitiesAction() {
		return new ViewModel();
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
}