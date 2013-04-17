<?php
namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;
use Search\Form\CourseSearchForm;
use Search\Model\Course;
use Search\Model\CourseSearchInput;

/**
 * SearchController
 * 
 * @author automatix
 */
class SearchController extends AbstractActionController {

	/**
	 * @var Search\Model\CourseTable
	 */
	protected $courseTable;
	
	public function searchAction() {
		return $this->redirect()->toRoute('search-courses');
	}
	
	public function searchCoursesAction() {
		$form = $this->getServiceLocator()->get('Search\Form\CourseSearchForm');
		$request = $this->getRequest();
		$formData = $request->getQuery()->getArrayCopy();
		if (!empty($formData)) {
			$courseSearchInput = new CourseSearchInput();
			$form->setInputFilter($courseSearchInput->getInputFilter());
			$form->setData($formData);
			if ($form->isValid()) {
				$courseSearchInput->exchangeArray($form->getData());
				$page = $this->params()->fromRoute('page');
				$paginator = $this->getCourseTable()->findAllByCriteria($courseSearchInput, $page);
			} else {
				$paginator = null;
			}
		} else {
			$paginator = null;
		}
		return new ViewModel(array(
			'form' => $form,
			'paginator' => $paginator,
			'cities' => $this->getServiceLocator()->get('Cache\Model\CityStorage')->getCities(),
			'formData' => $formData
		));
	}
	
	/**
	 * Gets a CourseTable object.
	 * @return Search\Model\CourseTable
	 */
	function getCourseTable() {
		if (!$this->courseTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->courseTable = $serviceLocator->get('Search\Model\CourseTable');
		}
		return $this->courseTable;
	}
	
}