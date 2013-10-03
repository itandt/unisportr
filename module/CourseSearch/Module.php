<?php
namespace CourseSearch;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use CourseSearch\Model\CourseTable;
use CourseSearch\Model\Course;
use CourseSearch\Controller\CourseSearchController;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements
	ConfigProviderInterface,
	ServiceProviderInterface,
	AutoloaderProviderInterface,
	ViewHelperProviderInterface {
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
					'ITT' => __DIR__ . '/../../vendor/ITT/library/ITT',
				),
			),
		);
	}
	
	public function getServiceConfig() {
		try {
			return array (
				'factories' => array(
					'CourseSearch\Model\CourseTable' => function($serviceManager) {
						$tableGateway = $serviceManager->get('CourseSearch\Model\CourseTableGateway');
						$table = new CourseTable(
							$tableGateway,
							$serviceManager->get('Config')['relevance_min'],
							$serviceManager->get('Config')['relevance_min_title'],
							$serviceManager->get('Config')['relevance_min_description'],
							$serviceManager->get('Config')['relevance_min_weightage_title'],
							$serviceManager->get('Config')['relevance_min_weightage_description']
						);
						return $table;
					},
					'CourseSearch\Model\CourseTableGateway' => function($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new Course());
						return new TableGateway('courses', $dbAdapter, null, $resultSetPrototype);
					},
					'CourseSearch\Form\CourseSearchForm' => function ($serviceManager) {
						$cacheService = $serviceManager->get('Cache\Model\CityStorage');
						$cities = $cacheService->getCities();
						$courseSearchForm = new Form\CourseSearchForm($cities);
						return $courseSearchForm;
					},
				)
			);
		} catch (\Exception $e) {
			do {
				echo $e->getMessage();
			} while ($e = $e->getPrevious());
		}
	}
	
	public function getViewHelperConfig() {
		return array(
			'factories' => array(
				'searhForm' => function($serviceManager) {
					$helper = new View\Helper\CourseSearchForm(array('render' => true, 'redirect' => false));
					$helper->setViewTemplate('course-search/course-search/course-search-form');
					$courseSearchForm = $serviceManager->getServiceLocator()->get('CourseSearch\Form\CourseSearchForm');
					$helper->setCourseSearchForm($courseSearchForm);
					return $helper;
				}
			)
		);
	}
	
}
