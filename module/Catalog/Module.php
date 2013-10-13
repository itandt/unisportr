<?php
namespace Catalog;

use Zend\EventManager\EventManager;
use Zend\Http\PhpEnvironment;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Catalog\Model\City;
use Catalog\Model\CityTable;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Catalog\Model\Sport;
use Catalog\Model\SportTable;
use Catalog\Model\Course;
use Catalog\Model\CourseTable;
use Catalog\Model\University;
use Catalog\Model\UniversityTable;

class Module implements ConfigProviderInterface, ServiceProviderInterface, AutoloaderProviderInterface {
	
	public function onBootstrap(MvcEvent $mvcEvent) {
	}
	
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
				'factories' =>array(
					'Catalog\Model\CityTable' => function ($serviceManager) {
						$tableGateway = $serviceManager->get('Catalog\Model\CityTableGateway');
						$table = new CityTable($tableGateway);
						return $table;
					},
					'Catalog\Model\CityTableGateway' => function ($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new City());
						return new TableGateway('cities', $dbAdapter, null, $resultSetPrototype);
					},
					'Catalog\Model\SportTable' => function ($serviceManager) {
						$tableGateway = $serviceManager->get('Catalog\Model\SportTableGateway');
						$table = new SportTable($tableGateway);
						return $table;
					},
					'Catalog\Model\SportTableGateway' => function ($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new Sport());
						return new TableGateway('sports', $dbAdapter, null, $resultSetPrototype);
					},
					'Catalog\Model\CourseTable' => function ($serviceManager) {
						$tableGateway = $serviceManager->get('Catalog\Model\CourseTableGateway');
						$table = new CourseTable($tableGateway);
						return $table;
					},
					'Catalog\Model\CourseTableGateway' => function ($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new Course());
						return new TableGateway('courses', $dbAdapter, null, $resultSetPrototype);
					},
					'Catalog\Model\UniversityTable' => function ($serviceManager) {
						$tableGateway = $serviceManager->get('Catalog\Model\UniversityTableGateway');
						$table = new UniversityTable($tableGateway);
						return $table;
					},
					'Catalog\Model\UniversityTableGateway' => function ($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new University());
						return new TableGateway('universities', $dbAdapter, null, $resultSetPrototype);
					},
				)
			);
		} catch (\Exception $e) {
			do {
				echo $e->getMessage();
			} while ($e = $e->getPrevious());
		}
	}
	
}
