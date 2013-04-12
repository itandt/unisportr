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
		
		$dateTimeNow = new \DateTime('now');
		$dateTimeCourseEndDate = new \DateTime($course->endDate);
		
		/*
		$interval = $dateTimeNow->diff($dateTimeCourseEndDate);
		echo
			$dateTimeNow->format('d.m.Y') . ' | ' .
			$dateTimeCourseEndDate->format('d.m.Y') . ' | ' .
			$interval->format('%d') . ' || '
		;
		*/
		
		if ($dateTimeCourseEndDate > $dateTimeNow) {
			$result = new ViewModel(array(
				'id' => $id,
				'course' => $course,
				'gMapsKey' => $this->getServiceLocator()->get('Config')['gMapsKey'],
			));
		} else {
			$result = $this->forward()->dispatch('Course\Controller\Course', array(
				'action' => 'course-expired',
				'course' => $course,
			));
		}
		
		return $result;
	}
	
	public function courseExpiredAction() {
		return new ViewModel(array(
			'course' => $this->params()->fromRoute()['course'],
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