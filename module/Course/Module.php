<?php
namespace Course;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Course\Model\Course;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Course\Model\CourseTable;
use ITT\View\Helper\MakeAddressGMapsFriendlier;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface, ServiceProviderInterface, AutoloaderProviderInterface {
	
	public function onBootstrap(MvcEvent $mvcEvent) {
		$application = $mvcEvent->getApplication();
		$serviceManager = $application->getServiceManager();
		
		$viewHelperManager = $serviceManager->get('ViewHelperManager');
		$viewHelperManager->setInvokableClass('makeaddressgmapsfriendlier', 'ITT\View\Helper\MakeAddressGMapsFriendlier');
	}
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
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
					'Course\Model\CourseTable' => function($serviceManager) {
						$tableGateway = $serviceManager->get('Course\Model\CourseTableGateway');
						$table = new CourseTable($tableGateway);
						return $table;
					},
					'Course\Model\CourseTableGateway' => function($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new Course());
						return new TableGateway('courses', $dbAdapter, null, $resultSetPrototype);
					}
				)
			);
		} catch (\Exception $e) {
			do {
				echo $e->getMessage();
			} while ($e = $e->getPrevious());
		}
	}
					
}