<?php
namespace Search;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Search\Model\CourseTable;
use Zend\Db\ResultSet\ResultSet;
use Search\Model\Course;
use Zend\Db\TableGateway\TableGateway;
use Search\Model\CityTable;
use Search\Model\City;
use Zend\Cache\Storage\Adapter\MemcachedOptions;
use Zend\Cache\Storage\Adapter\Memcached;
use Search\Model\CityStorage;

class Module implements ConfigProviderInterface, ServiceProviderInterface, AutoloaderProviderInterface {
	
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
				),
			),
		);
	}
	
	public function getServiceConfig() {
		try {
			return array (
				'factories' => array(
					'Search\Model\CourseTable' => function($serviceManager) {
						$tableGateway = $serviceManager->get('Search\Model\CourseTableGateway');
						$table = new CourseTable($tableGateway);
						return $table;
					},
					'Search\Model\CourseTableGateway' => function($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new Course());
						return new TableGateway('courses', $dbAdapter, null, $resultSetPrototype);
					},
					'Search\Model\CityTable' => function ($serviceManager) {
						$tableGateway = $serviceManager->get('Search\Model\CityTableGateway');
						$table = new CityTable($tableGateway);
						return $table;
					},
					'Search\Model\CityTableGateway' => function ($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new City());
						return new TableGateway('cities', $dbAdapter, null, $resultSetPrototype);
					},
					'Cache\Adapter\Memcached' => function ($serviceManager) {
						$memcached = new Memcached($serviceManager->get('Cache\Adapter\MemcachedOptions'));
						return $memcached;
					},
					'Cache\Adapter\MemcachedOptions' => function ($serviceManager) {
						return new MemcachedOptions(array(
							'ttl'			=> 60, // 1 minute // 60 * 60 * 24 * 7, // 1 week
							'namespace'		=> 'cache_listener',
							'key_pattern'	=> null,
							'readable'		=> true,
							'writable'		=> true,
							'servers'		=> 'localhost',
						));
					},
					'Search\Model\CityStorage' => function ($serviceManager) {
						return new CityStorage(
							$serviceManager->get('Search\Model\CityTable'),
							$serviceManager->get('Cache\Adapter\Memcached')
						);
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
