<?php
namespace Course\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;

/**
 * CourseController
 * 
 * @author automatix
 */
class CourseController extends AbstractActionController {

	/**
	 * @var Zend\Db\TableGateway\TableGateway
	 */
	protected $courseTable;
	
	public function displayCourseAction() {
		$id = $this->params()->fromRoute('id', null);
		$title = $this->params()->fromRoute('title', null);
		$course = $this->getCourseTable()->findOnceByID($id)->current();
		return new ViewModel(array(
			'id' => $id,
			'courseTitle' => $title,
			'course' => $course,
			'gMapsKey' => $this->getServiceLocator()->get('Config')['gMapsKey'],
		));
	}
	
	/**
	 * Gets a CourseTable object.
	 * @return CourseTable
	 */
	function getCourseTable() {
		if (!$this->courseTable) {
			$serviceLocator = $this->getServiceLocator();
			$this->courseTable = $serviceLocator->get('Course\Model\CourseTable');
		}
		return $this->courseTable;
	}
	
}