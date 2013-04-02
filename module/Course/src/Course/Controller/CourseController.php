<?php
namespace Course\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * CourseController
 * 
 * @author automatix
 */
class CourseController extends AbstractActionController {
	
	public function displayCourseAction() {
		$id = $this->params()->fromRoute('id', null);
		$title = $this->params()->fromRoute('title', null);
		$course = new \stdClass();
		return new ViewModel(array(
			'id' => $id,
			'title' => $title,
			'course' => $course
		));
	}
	
}