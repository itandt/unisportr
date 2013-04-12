<?php
namespace Cache;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;
use Zend\Cache\Storage\Adapter\MemcachedOptions;
use Zend\Cache\Storage\Adapter\Memcached;
use Catalog\Model\City;
use Catalog\Model\University;
use Cache\Model\CityStorage;
use Cache\Model\UniversityStorage;

class Module implements ConfigProviderInterface, ServiceProviderInterface, AutoloaderProviderInterface {
	
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
				),
			),
		);
	}
	
	public function getServiceConfig() {
		try {
			return array (
				'factories' => array(
					'Zend\Cache\Adapter\Memcached' => function ($serviceManager) {
						$memcached = new Memcached($serviceManager->get('Zend\Cache\Adapter\MemcachedOptions'));
						return $memcached;
					},
					'Zend\Cache\Adapter\MemcachedOptions' => function ($serviceManager) {
						return new MemcachedOptions(array(
							'ttl'			=> $serviceManager->get('Config')['ttl_cities'],
							'namespace'		=> CityStorage::CACHE_LISTENER_CITIES,
							'key_pattern'	=> null,
							'readable'		=> true,
							'writable'		=> true,
							'servers'		=> 'localhost',
						));
					},
					'Cache\Model\CityStorage' => function ($serviceManager) {
						return new CityStorage(
							$serviceManager->get('Catalog\Model\CityTable'),
							$serviceManager->get('Zend\Cache\Adapter\Memcached')
						);
					},
					'Zend\Cache\Adapter\MemcachedOptions' => function ($serviceManager) {
						return new MemcachedOptions(array(
							'ttl'			=> $serviceManager->get('Config')['ttl_universities'],
							'namespace'		=> UniversityStorage::CACHE_LISTENER_UNIVERSITIES,
							'key_pattern'	=> null,
							'readable'		=> true,
							'writable'		=> true,
							'servers'		=> 'localhost',
						));
					},
					'Cache\Model\UniversityStorage' => function ($serviceManager) {
						return new UniversityStorage(
							$serviceManager->get('Catalog\Model\UniversityTable'),
							$serviceManager->get('Zend\Cache\Adapter\Memcached')
						);
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
