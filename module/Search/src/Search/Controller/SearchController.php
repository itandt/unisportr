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
		$form = new CourseSearchForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$courseSearchInput = new CourseSearchInput();
			$form->setInputFilter($courseSearchInput->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$courseSearchInput->exchangeArray($form->getData());
				$courses = $this->getCourseTable()->findAllByCriteria($courseSearchInput);
			} else {
				$courses = null;
			}
		} else {
			$courses = null;
		}
		return new ViewModel(array(
			'form' => $form,
			'courses' => $courses,
			'cities' => $this->getServiceLocator()->get('Cache\Model\CityStorage')->getCities(),
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