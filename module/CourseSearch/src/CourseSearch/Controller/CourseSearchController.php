<?php
namespace CourseSearch\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;
use CourseSearch\Form\CourseSearchForm;
use CourseSearch\Model\Course;
use CourseSearch\Model\CourseSearchInput;

/**
 * CourseSearchController
 * 
 * @author automatix
 */
class CourseSearchController extends AbstractActionController {

	/**
	 * @var CourseSearch\Model\CourseTable
	 */
	protected $courseTable;
	
	public function searchAction() {
		return $this->redirect()->toRoute('course-search');
	}
	
	public function searchCoursesAction() {
		$form = $this->getServiceLocator()->get('CourseSearch\Form\CourseSearchForm');
		$request = $this->getRequest();
		$formData = $request->getQuery()->getArrayCopy();
		if (!empty($formData)) {
			$courseCourseSearchInput = new CourseSearchInput();
			$form->setInputFilter($courseCourseSearchInput->getInputFilter());
			$form->setData($formData);
			if ($form->isValid()) {
				$courseCourseSearchInput->exchangeArray($form->getData());
				$page = $this->params()->fromRoute('page');
				$paginator = $this->getCourseTable()->findAllByCriteria($courseCourseSearchInput, $page);
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
	 * @return CourseSearch\Model\CourseTable
	 */
	function getCourseTable() {
		if (!$this->courseTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->courseTable = $serviceLocator->get('CourseSearch\Model\CourseTable');
		}
		return $this->courseTable;
	}
	
}