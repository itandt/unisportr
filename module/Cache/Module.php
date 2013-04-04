<?php
namespace Cache;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Cache\Storage\Adapter\MemcachedOptions;
use Zend\Cache\Storage\Adapter\Memcached;
use Cache\Model\CityTable;
use Cache\Model\City;
use Cache\Model\CityStorage;

class Module
{
    public function getConfig()
    {
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
					'Cache\Model\CityTable' => function ($serviceManager) {
						$tableGateway = $serviceManager->get('Cache\Model\CityTableGateway');
						$table = new CityTable($tableGateway);
						return $table;
					},
					'Cache\Model\CityTableGateway' => function ($serviceManager) {
						$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new City());
						return new TableGateway('cities', $dbAdapter, null, $resultSetPrototype);
					},
					'Zend\Cache\Adapter\Memcached' => function ($serviceManager) {
						$memcached = new Memcached($serviceManager->get('Zend\Cache\Adapter\MemcachedOptions'));
						return $memcached;
					},
					'Zend\Cache\Adapter\MemcachedOptions' => function ($serviceManager) {
						return new MemcachedOptions(array(
							'ttl'			=> 60, // 1 minute // 60 * 60 * 24 * 7, // 1 week
							'namespace'		=> 'cache_listener',
							'key_pattern'	=> null,
							'readable'		=> true,
							'writable'		=> true,
							'servers'		=> 'localhost',
						));
					},
					'Cache\Model\CityStorage' => function ($serviceManager) {
						return new CityStorage(
							$serviceManager->get('Cache\Model\CityTable'),
							$serviceManager->get('Zend\Cache\Adapter\Memcached')
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
